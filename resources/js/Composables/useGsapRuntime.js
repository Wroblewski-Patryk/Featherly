import { onMounted, onUnmounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function useGsapRuntime() {
    const animateBlock = (el, animation) => {
        if (!el || !animation || !animation.enabled) return;

        const { preset, duration, delay, trigger } = animation;

        // Define presets
        const presets = {
            fadeUp: { opacity: 0, y: 50 },
            fadeIn: { opacity: 0 },
            slideLeft: { opacity: 0, x: -100 },
            scaleIn: { opacity: 0, scale: 0.8 },
        };

        const startVars = presets[preset] || presets.fadeUp;
        const endVars = {
            opacity: 1,
            y: 0,
            x: 0,
            scale: 1,
            duration: duration || 1,
            delay: delay || 0,
            ease: 'power2.out'
        };

        if (trigger === 'on-load') {
            gsap.fromTo(el, startVars, endVars);
        } else {
            // In view trigger
            gsap.fromTo(el, startVars, {
                ...endVars,
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                }
            });
        }
    };

    const cleanup = () => {
        ScrollTrigger.getAll().forEach(t => t.kill());
    };

    return { animateBlock, cleanup };
}
