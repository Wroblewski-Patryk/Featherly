<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlpineFuturaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Theme Configuration
        $newThemeColors = [
            'primary' => '#ffffff',
            'secondary' => '#151b2b',
            'accent' => '#0ea5e9',
            'base_100' => '#050a14',
            'base_200' => '#0b0f19',
            'base_300' => '#151b2b',
            'neutral' => '#f8fafc',
            'info' => '#3b82f6',
            'success' => '#22c55e',
            'warning' => '#eab308',
            'error' => '#ef4444'
        ];
        
        Setting::updateOrCreate(
            ['key' => 'theme_colors'],
            ['value' => $newThemeColors]
        );

        // 2. Templates (Header/Footer)
        $headerTemplate = Template::where('type', 'header')->first();
        if ($headerTemplate) {
            $headerTemplate->update([
                'title' => ['pl' => 'Alpine Header', 'en' => 'Alpine Header'],
                'content' => [
                    'pl' => [
                        [
                            'id' => 'header_navbar',
                            'type' => 'navbar',
                            'content' => ['title' => 'ALPINE FUTURA', 'links' => ['ARCHITECTURE', 'DEVELOPMENT', 'AESTHETICS', 'CONTACT'], 'actionButton' => 'CONNECT'],
                            'settings' => [
                                'style' => [
                                    'bgColor' => 'transparent',
                                    'textColor' => '#ffffff',
                                    'display' => 'flex',
                                    'justifyContent' => 'between'
                                ]
                            ]
                        ]
                    ],
                    'en' => [
                        [
                            'id' => 'header_navbar_en',
                            'type' => 'navbar',
                            'content' => ['title' => 'ALPINE FUTURA', 'links' => ['ARCHITECTURE', 'DEVELOPMENT', 'AESTHETICS', 'CONTACT'], 'actionButton' => 'CONNECT'],
                            'settings' => [
                                'style' => [
                                    'bgColor' => 'transparent',
                                    'textColor' => '#ffffff',
                                    'display' => 'flex',
                                    'justifyContent' => 'between'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        }

        $footerTemplate = Template::where('type', 'footer')->first();
        if ($footerTemplate) {
            $footerTemplate->update([
                'title' => ['pl' => 'Alpine Footer', 'en' => 'Alpine Footer'],
                'content' => [
                    'pl' => [
                        [
                            'id' => 'footer_container',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'footer', 'isBoxed' => true, 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'row', 'align' => 'center', 'justify' => 'between']],
                            'children' => [
                                [
                                    'id' => 'footer_logo',
                                    'type' => 'heading',
                                    'content' => ['text' => 'ALPINE FUTURA', 'level' => 3],
                                    'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '1rem', 'fontWeight' => '900', 'letterSpacing' => '0.1em']]
                                ],
                                [
                                    'id' => 'footer_links',
                                    'type' => 'container',
                                    'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'row', 'gap' => '8']],
                                    'children' => [
                                        ['type' => 'paragraph', 'content' => ['text' => 'PRIVACY'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                        ['type' => 'paragraph', 'content' => ['text' => 'ARCHIVE'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                        ['type' => 'paragraph', 'content' => ['text' => 'PROCESS'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                    ]
                                ],
                                [
                                    'id' => 'footer_text',
                                    'type' => 'paragraph',
                                    'content' => ['text' => '© 2026 ALPINE FUTURA. ONLY AT THE ETHEREAL PEAK.'],
                                    'settings' => ['style' => ['textColor' => '#64748b', 'fontSize' => '0.65rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]
                                ]
                            ],
                            'settings' => ['style' => ['paddingY' => '4rem', 'bgColor' => '#050a14']]
                        ]
                    ],
                    'en' => [
                        [
                            'id' => 'footer_container_en',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'footer', 'isBoxed' => true, 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'row', 'align' => 'center', 'justify' => 'between']],
                            'children' => [
                                [
                                    'id' => 'footer_logo_en',
                                    'type' => 'heading',
                                    'content' => ['text' => 'ALPINE FUTURA', 'level' => 3],
                                    'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '1rem', 'fontWeight' => '900', 'letterSpacing' => '0.1em']]
                                ],
                                [
                                    'id' => 'footer_links_en',
                                    'type' => 'container',
                                    'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'row', 'gap' => '8']],
                                    'children' => [
                                        ['type' => 'paragraph', 'content' => ['text' => 'PRIVACY'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                        ['type' => 'paragraph', 'content' => ['text' => 'ARCHIVE'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                        ['type' => 'paragraph', 'content' => ['text' => 'PROCESS'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]],
                                    ]
                                ],
                                [
                                    'id' => 'footer_text_en',
                                    'type' => 'paragraph',
                                    'content' => ['text' => '© 2026 ALPINE FUTURA. ONLY AT THE ETHEREAL PEAK.'],
                                    'settings' => ['style' => ['textColor' => '#64748b', 'fontSize' => '0.65rem', 'letterSpacing' => '0.1em', 'textTransform' => 'uppercase']]
                                ]
                            ],
                            'settings' => ['style' => ['paddingY' => '4rem', 'bgColor' => '#050a14']]
                        ]
                    ]
                ]
            ]);
        }

        // 3. Page Content
        $bgUrl = '/storage/media/oiuKB9ha6MvviV8nM0EgHsvCGkXwPD41XM9TAmT1.png'; // Media ID 27

        $homePageContent = [
            'pl' => [
                [
                    'id' => 'hero_section',
                    'type' => 'container',
                    'content' => [
                        'htmlTag' => 'section',
                        'isBoxed' => true,
                        'flexConfig' => ['direction' => 'col', 'align' => 'center', 'justify' => 'center', 'gap' => '6'],
                        'layoutType' => 'flex'
                    ],
                    'children' => [
                        [
                            'id' => 'hero_nebula',
                            'type' => 'paragraph',
                            'content' => ['text' => '<span style="letter-spacing: 0.3em; color: #38bdf8; font-weight: bold; font-size: 0.70rem; border: 1px solid rgba(56,189,248,0.3); padding: 6px 16px; border-radius: 99px; background: rgba(56,189,248,0.05); text-transform: uppercase;">PERSONAL NARRATIVE 2024 // ARCHIVE 01</span>'],
                            'settings' => ['style' => ['marginBottom' => '1.5rem', 'textAlign' => 'center']]
                        ],
                        [
                            'id' => 'hero_h1',
                            'type' => 'heading',
                            'content' => ['text' => 'WELCOME <br><span style="color: #60a5fa">TO ZENITH.</span>', 'level' => 1, 'align' => 'center'],
                            'settings' => [
                                'style' => [
                                    'textColor' => '#ffffff',
                                    'fontSize' => '6rem',
                                    'fontWeight' => '900',
                                    'lineHeight' => '1',
                                    'marginBottom' => '1.5rem',
                                    'letterSpacing' => '-0.02em',
                                    'textTransform' => 'uppercase'
                                ]
                            ]
                        ],
                        [
                            'id' => 'hero_p',
                            'type' => 'paragraph',
                            'content' => ['text' => 'At the ethereal peak of digital craft, we architect atmospheres where high-tech utility meets sub-zero precision. Every interaction is a summit scaled.'],
                            'settings' => [
                                'style' => [
                                    'textColor' => '#e2e8f0',
                                    'fontSize' => '1.125rem',
                                    'textAlign' => 'center',
                                    'maxWidth' => '600px',
                                    'marginBottom' => '3rem',
                                    'lineHeight' => '1.6'
                                ]
                            ]
                        ],
                        [
                            'id' => 'hero_cta',
                            'type' => 'paragraph',
                            'content' => ['text' => '<div style="display: flex; align-items: center; gap: 1rem; width: fit-content; margin: 0 auto; cursor: pointer;"><div style="height: 1px; width: 40px; background: #38bdf8;"></div><span style="color: #38bdf8; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase;">EXPLORE ARCHIVE</span></div>'],
                            'settings' => ['style' => ['marginBottom' => '5rem']]
                        ],
                        [
                            'id' => 'hero_scroll',
                            'type' => 'paragraph',
                            'content' => ['text' => '<div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; opacity: 0.7; margin: 0 auto;"><span style="color: #94a3b8; font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;">SCROLL TO EXPLORE</span><div style="width: 1px; height: 30px; background: #38bdf8;"></div></div>'],
                        ]
                    ],
                    'settings' => [
                        'style' => [
                            'minHeight' => '100vh',
                            'paddingTop' => '8rem',
                            'display' => 'flex',
                            'alignItems' => 'center',
                            'justifyContent' => 'center',
                            'flexDirection' => 'column',
                            'backgroundFill' => [
                                'type' => 'image',
                                'image' => $bgUrl,
                                'gradient' => 'linear-gradient(180deg, rgba(5,10,20,0.5) 0%, rgba(5,10,20,1) 100%)'
                            ]
                        ]
                    ]
                ],
                [
                    'id' => 'curation_section',
                    'type' => 'container',
                    'content' => [
                        'htmlTag' => 'section',
                        'isBoxed' => true,
                        'layoutType' => 'flex',
                        'flexConfig' => ['direction' => 'row', 'wrap' => 'wrap', 'gap' => '8']
                    ],
                    'children' => [
                        [
                            'id' => 'c_left',
                            'type' => 'container',
                            'content' => [
                                'htmlTag' => 'div',
                                'layoutType' => 'flex',
                                'flexConfig' => ['direction' => 'col', 'gap' => '6']
                            ],
                            'settings' => [
                                'style' => [
                                    'bgColor' => '#0b0f19',
                                    'padding' => '4rem',
                                    'borderRadius' => '1.5rem',
                                    'border' => '1px solid rgba(255,255,255,0.05)',
                                    'width' => '100%',
                                    'maxWidth' => '100%',
                                    // Normally we would use customClass w-full md:w-[60%] but inline styles are safer for cross-engine parsing
                                    'flex' => '2'
                                ]
                            ],
                            'children' => [
                                [
                                    'id' => 'icon_curation',
                                    'type' => 'custom_code',
                                    'content' => ['html' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 22H22L12 2Z" fill="#38bdf8"/></svg>'],
                                    'settings' => ['style' => ['marginBottom' => '1rem']]
                                ],
                                [
                                    'id' => 'curation_h2',
                                    'type' => 'heading',
                                    'content' => ['text' => 'Curation of <br><span style="color: #38bdf8; font-style: italic;">High-Altitude</span> Design.', 'level' => 2],
                                    'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '3rem', 'fontWeight' => '800', 'lineHeight' => '1.1']]
                                ],
                                [
                                    'id' => 'curation_p',
                                    'type' => 'paragraph',
                                    'content' => ['text' => 'A synthesis of technical precision and artistic mystery. We don\'t just build interfaces; we architect digital atmospheres that provoke emotion and command attention at any scale.'],
                                    'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '1.125rem', 'lineHeight' => '1.6', 'maxWidth' => '90%']]
                                ],
                                [
                                    'id' => 'curation_tags',
                                    'type' => 'container',
                                    'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'row', 'gap' => '4']],
                                    'children' => [
                                        ['type' => 'paragraph', 'content' => ['text' => '<span style="border: 1px solid rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 99px; font-size: 0.65rem; letter-spacing: 0.1em; color: #94a3b8; text-transform: uppercase;">AESTHETICS</span>']],
                                        ['type' => 'paragraph', 'content' => ['text' => '<span style="border: 1px solid rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 99px; font-size: 0.65rem; letter-spacing: 0.1em; color: #94a3b8; text-transform: uppercase;">PERFORMANCE</span>']],
                                    ],
                                    'settings' => ['style' => ['marginTop' => '1rem']]
                                ]
                            ]
                        ],
                        [
                            'id' => 'c_right',
                            'type' => 'container',
                            'content' => [
                                'htmlTag' => 'div',
                                'layoutType' => 'flex',
                                'flexConfig' => ['direction' => 'col', 'justify' => 'between']
                            ],
                            'settings' => [
                                'style' => [
                                    'bgColor' => '#0b0f19',
                                    'padding' => '4rem',
                                    'borderRadius' => '1.5rem',
                                    'border' => '1px solid rgba(255,255,255,0.05)',
                                    'flex' => '1',
                                    'minWidth' => '30%'
                                ]
                            ],
                            'children' => [
                                [
                                    'id' => 'c_right_01',
                                    'type' => 'heading',
                                    'content' => ['text' => '01', 'level' => 2],
                                    'settings' => ['style' => ['textColor' => 'rgba(255,255,255,0.05)', 'fontSize' => '6rem', 'fontWeight' => '900', 'lineHeight' => '1']]
                                ],
                                [
                                    'id' => 'c_right_bottom',
                                    'type' => 'container',
                                    'content' => ['htmlTag' => 'div'],
                                    'children' => [
                                        [
                                            'id' => 'c_right_h3',
                                            'type' => 'heading',
                                            'content' => ['text' => 'THE VISION', 'level' => 3],
                                            'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '1rem', 'fontWeight' => '800', 'marginBottom' => '1rem', 'textTransform' => 'uppercase']]
                                        ],
                                        [
                                            'id' => 'c_right_p',
                                            'type' => 'paragraph',
                                            'content' => ['text' => 'Redefining the standard of interaction in a pixel-flat era. Embracing depth, verticality, and the quiet spaces between pixels.'],
                                            'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.875rem', 'lineHeight' => '1.6']]
                                        ]
                                    ],
                                    'settings' => ['style' => ['marginTop' => '4rem']]
                                ]
                            ]
                        ]
                    ],
                    'settings' => ['style' => ['paddingY' => '8rem', 'bgColor' => '#050a14']]
                ],
                [
                    'id' => 'nebula_banner',
                    'type' => 'container',
                    'content' => [
                        'htmlTag' => 'section',
                        'isBoxed' => true,
                        'layoutType' => 'flex',
                        'flexConfig' => ['direction' => 'row', 'wrap' => 'wrap', 'justify' => 'between', 'align' => 'end']
                    ],
                    'children' => [
                        [
                            'id' => 'nebula_left',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'div'],
                            'children' => [
                                [
                                    'id' => 'nebula_tag',
                                    'type' => 'paragraph',
                                    'content' => ['text' => '< ARC STORY // SERIE 04 >'],
                                    'settings' => ['style' => ['textColor' => '#38bdf8', 'fontSize' => '0.75rem', 'letterSpacing' => '0.2em', 'fontWeight' => '700', 'marginBottom' => '1rem']]
                                ],
                                [
                                    'id' => 'nebula_title',
                                    'type' => 'heading',
                                    'content' => ['text' => 'NEBULA_OS <span style="font-style: italic; opacity: 0.5; color: #ffffff;">SYSTEM</span>', 'level' => 2],
                                    'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '4rem', 'fontWeight' => '900', 'lineHeight' => '1']]
                                ]
                            ]
                        ],
                        [
                            'id' => 'nebula_btn',
                            'type' => 'button',
                            'content' => ['label' => 'VIEW PROJECT', 'url' => '#', 'style' => 'neutral'],
                            'settings' => ['style' => ['marginTop' => '2rem']]
                        ]
                    ],
                    'settings' => [
                        'style' => [
                            'paddingTop' => '10rem',
                            'paddingBottom' => '4rem',
                            'paddingLeft' => '4rem',
                            'paddingRight' => '4rem',
                            'borderRadius' => '2rem',
                            'margin' => '0 2rem',
                            'backgroundFill' => [
                                'type' => 'image',
                                'image' => $bgUrl,
                                'gradient' => 'linear-gradient(180deg, rgba(5,10,20,0) 0%, rgba(5,10,20,0.8) 100%)'
                            ]
                        ]
                    ]
                ],
                [
                    'id' => 'features_3col',
                    'type' => 'container',
                    'content' => [
                        'htmlTag' => 'section',
                        'isBoxed' => true,
                        'layoutType' => 'grid',
                        'gridConfig' => ['cols' => '3', 'gap' => '6']
                    ],
                    'children' => [
                        [
                            'id' => 'feat_1',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'col', 'gap' => '4']],
                            'settings' => ['style' => ['bgColor' => '#0b0f19', 'padding' => '3rem', 'borderRadius' => '1rem', 'border' => '1px solid rgba(255,255,255,0.05)']],
                            'children' => [
                                ['type' => 'custom_code', 'content' => ['html' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 22H22L12 2Z" fill="#38bdf8"/></svg>']],
                                ['type' => 'heading', 'content' => ['text' => 'TECHNICAL DEPTH', 'level' => 3], 'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '0.875rem', 'fontWeight' => '800', 'textTransform' => 'uppercase']]],
                                ['type' => 'paragraph', 'content' => ['text' => 'High-performance architecture meeting colloidal pixel aesthetics, from Z-index spatial manipulation to real-time media.'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.875rem', 'lineHeight' => '1.6']]]
                            ]
                        ],
                        [
                            'id' => 'feat_2',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'col', 'gap' => '4']],
                            'settings' => ['style' => ['bgColor' => '#0b0f19', 'padding' => '3rem', 'borderRadius' => '1rem', 'border' => '1px solid rgba(255,255,255,0.05)']],
                            'children' => [
                                ['type' => 'custom_code', 'content' => ['html' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 22L14 2H20L10 22H4Z" fill="#38bdf8"/></svg>']],
                                ['type' => 'heading', 'content' => ['text' => 'BESPOKE LAYOUTS', 'level' => 3], 'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '0.875rem', 'fontWeight' => '800', 'textTransform' => 'uppercase']]],
                                ['type' => 'paragraph', 'content' => ['text' => 'Dynamic grid systems that breathe and adapt to the content\'s natural rhythm.'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.875rem', 'lineHeight' => '1.6']]]
                            ]
                        ],
                        [
                            'id' => 'feat_3',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'div', 'layoutType' => 'flex', 'flexConfig' => ['direction' => 'col', 'gap' => '4']],
                            'settings' => ['style' => ['bgColor' => '#0b0f19', 'padding' => '3rem', 'borderRadius' => '1rem', 'border' => '1px solid rgba(255,255,255,0.05)']],
                            'children' => [
                                ['type' => 'custom_code', 'content' => ['html' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 22M2 12H22M6 6L18 18M6 18L18 6" stroke="#c084fc" stroke-width="2" stroke-linecap="round"/></svg>']],
                                ['type' => 'heading', 'content' => ['text' => 'FUTURISTIC SOUL', 'level' => 3], 'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '0.875rem', 'fontWeight' => '800', 'textTransform' => 'uppercase']]],
                                ['type' => 'paragraph', 'content' => ['text' => 'Atmospheric transitions and spatial interactions that define the user experience.'], 'settings' => ['style' => ['textColor' => '#94a3b8', 'fontSize' => '0.875rem', 'lineHeight' => '1.6']]]
                            ]
                        ]
                    ],
                    'settings' => ['style' => ['paddingY' => '8rem', 'bgColor' => '#050a14']]
                ],
                [
                    'id' => 'cta_section',
                    'type' => 'container',
                    'content' => [
                        'htmlTag' => 'section',
                        'isBoxed' => true,
                        'layoutType' => 'flex',
                        'flexConfig' => ['direction' => 'col', 'align' => 'center', 'justify' => 'center']
                    ],
                    'children' => [
                        [
                            'id' => 'cta_h2',
                            'type' => 'heading',
                            'content' => ['text' => 'READY TO <br><span style="-webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent;">ASCEND?</span>', 'level' => 2, 'align' => 'center'],
                            'settings' => ['style' => ['textColor' => '#ffffff', 'fontSize' => '6rem', 'fontWeight' => '900', 'lineHeight' => '0.9', 'marginBottom' => '3rem', 'textAlign' => 'center', 'letterSpacing' => '-0.02em']]
                        ],
                        [
                            'id' => 'cta_btn',
                            'type' => 'container',
                            'content' => ['htmlTag' => 'div'],
                            'children' => [
                                ['type' => 'custom_code', 'content' => ['html' => '<a href="#" style="background: white; color: black; font-weight: 800; padding: 16px 32px; border-radius: 99px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; font-size: 0.9rem; transition: transform 0.2s;">START A JOURNEY <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>']]
                            ]
                        ]
                    ],
                    'settings' => [
                        'style' => [
                            'paddingTop' => '6rem',
                            'paddingBottom' => '8rem',
                            'bgColor' => '#050a14',
                            'display' => 'flex',
                            'justifyContent' => 'center',
                            'alignItems' => 'center',
                        ]
                    ]
                ]
            ],
            'en' => [] 
        ];

        $homePageContent['en'] = $homePageContent['pl'];

        $homePage = Page::updateOrCreate(
            ['slug->pl' => 'home'],
            [
                'title' => ['pl' => 'Alpine Futura', 'en' => 'Alpine Futura'],
                'slug' => ['pl' => 'home', 'en' => 'home'],
                'content' => $homePageContent,
                'status' => 'published',
            ]
        );

        // Update home_page_id setting
        Setting::updateOrCreate(
            ['key' => 'home_page_id'],
            ['value' => (string)$homePage->id]
        );
    }
}
