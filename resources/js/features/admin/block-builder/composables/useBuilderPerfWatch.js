import { onMounted, onUnmounted } from 'vue';

function parseThreshold(value, fallback) {
    const parsed = Number.parseInt(value ?? '', 10);
    return Number.isFinite(parsed) && parsed > 0 ? parsed : fallback;
}

export function useBuilderPerfWatch() {
    let frameRequestId = null;
    let perfObserver = null;
    let previousFrame = 0;
    let droppedFrameCount = 0;
    let running = false;

    const isEnabled = () => {
        if (typeof window === 'undefined') return false;

        const queryEnabled = new URLSearchParams(window.location.search).get('perfWatch') === '1';
        const localStorageEnabled = window.localStorage?.getItem('builder:perfWatch') === '1';

        return queryEnabled || localStorageEnabled;
    };

    const fpsWarnThreshold = parseThreshold(import.meta.env.VITE_BUILDER_PERF_FPS_WARN, 30);
    const frameWarnThresholdMs = parseThreshold(import.meta.env.VITE_BUILDER_PERF_FRAME_WARN_MS, 32);
    const memoryWarnThresholdMb = parseThreshold(import.meta.env.VITE_BUILDER_PERF_MEMORY_WARN_MB, 256);

    const warn = (message, payload = {}) => {
        // Dedicated prefix allows simple log filtering in browser devtools.
        console.warn('[builder:perf-watch]', message, payload);
    };

    const stopFrameLoop = () => {
        if (frameRequestId !== null) {
            cancelAnimationFrame(frameRequestId);
            frameRequestId = null;
        }
    };

    const startFrameLoop = () => {
        const frame = (timestamp) => {
            if (!running) return;

            if (previousFrame > 0) {
                const delta = timestamp - previousFrame;
                const fps = delta > 0 ? Math.round(1000 / delta) : 0;

                if (delta >= frameWarnThresholdMs || fps <= fpsWarnThreshold) {
                    droppedFrameCount += 1;
                    warn('Slow frame detected', { deltaMs: Math.round(delta), fps, droppedFrameCount });
                }
            }

            previousFrame = timestamp;
            frameRequestId = requestAnimationFrame(frame);
        };

        frameRequestId = requestAnimationFrame(frame);
    };

    const startLongTaskObserver = () => {
        if (typeof PerformanceObserver === 'undefined') return;

        try {
            perfObserver = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    warn('Long task detected', { durationMs: Math.round(entry.duration) });
                }
            });

            perfObserver.observe({ type: 'longtask', buffered: true });
        } catch (_) {
            // Ignore unsupported observer types in older browsers.
        }
    };

    const checkMemoryBudget = () => {
        const memory = performance?.memory;
        if (!memory?.usedJSHeapSize) return;

        const usedMb = Math.round(memory.usedJSHeapSize / (1024 * 1024));

        if (usedMb >= memoryWarnThresholdMb) {
            warn('High JS heap usage detected', { usedMb, thresholdMb: memoryWarnThresholdMb });
        }
    };

    const stop = () => {
        running = false;
        stopFrameLoop();

        if (perfObserver) {
            perfObserver.disconnect();
            perfObserver = null;
        }
    };

    const start = () => {
        if (running || !isEnabled()) return;

        running = true;
        previousFrame = 0;
        droppedFrameCount = 0;

        startFrameLoop();
        startLongTaskObserver();
        checkMemoryBudget();

        warn('Performance watch enabled', {
            fpsWarnThreshold,
            frameWarnThresholdMs,
            memoryWarnThresholdMb,
        });
    };

    onMounted(start);
    onUnmounted(stop);

    return { start, stop, isEnabled };
}
