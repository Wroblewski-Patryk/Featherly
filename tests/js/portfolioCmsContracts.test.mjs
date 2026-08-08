import test from 'node:test';
import assert from 'node:assert/strict';
import fs from 'node:fs';

const dynamicBlock = fs.readFileSync(
    new URL('../../resources/js/features/admin/block-builder/components/DynamicBlock.vue', import.meta.url),
    'utf8',
);
const navigationSettings = fs.readFileSync(
    new URL('../../resources/js/features/admin/block-builder/components/Settings/NavigationSettings.vue', import.meta.url),
    'utf8',
);
const pageEditor = fs.readFileSync(
    new URL('../../resources/js/Pages/Admin/Pages/Edit.vue', import.meta.url),
    'utf8',
);
const fillControl = fs.readFileSync(
    new URL('../../resources/js/features/admin/theme/components/FillControl.vue', import.meta.url),
    'utf8',
);
const linkedUnitInput = fs.readFileSync(
    new URL('../../resources/js/features/admin/theme/components/LinkedUnitInput.vue', import.meta.url),
    'utf8',
);

test('image block renders its persisted media URL with accessible alternative text', () => {
    assert.match(dynamicBlock, /block\.type === 'image'/);
    assert.match(dynamicBlock, /resolveMediaUrl\(resolvedContent\.url\)/);
    assert.match(dynamicBlock, /:alt="t\(resolvedContent\.alt\)"/);
});

test('navbar supports persisted destinations for brand, links, and action', () => {
    assert.match(navigationSettings, /v-model="link\.href"/);
    assert.match(navigationSettings, /v-model="modelValue\.actionHref"/);
    assert.match(dynamicBlock, /link\.href \|\| '#'/);
    assert.match(dynamicBlock, /resolvedContent\?\.actionHref \|\| '#contact'/);
    assert.match(dynamicBlock, /:aria-expanded="navbarOpen \? 'true' : 'false'"/);
    assert.match(dynamicBlock, /id="`\$\{blockId\}-mobile-menu`"/);
});

test('page editor refreshes its lock from the server response', () => {
    assert.match(pageEditor, /response\?\.props\?\.page\?\.updated_at/);
    assert.doesNotMatch(pageEditor, /form\.optimistic_lock = new Date\(\)\.toISOString\(\)/);
});

test('style control buttons never submit the surrounding editor form', () => {
    assert.doesNotMatch(fillControl, /<button(?![^>]*type="button")/);
    assert.doesNotMatch(linkedUnitInput, /<button(?![^>]*type="button")/);
});
