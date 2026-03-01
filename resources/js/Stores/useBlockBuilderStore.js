import { defineStore } from 'pinia';

export const useBlockBuilderStore = defineStore('blockBuilder', {
    state: () => ({
        blocks: [],
        activeBlockId: null,
        isDirty: false,
    }),
    actions: {
        setBlocks(initialBlocks) {
            this.blocks = Array.isArray(initialBlocks) ? initialBlocks : [];
            this.isDirty = false;
        },
        addBlock(type) {
            const newBlock = {
                id: 'block_' + Math.random().toString(36).substr(2, 9),
                type: type,
                content: {},
                appearance: {
                    marginTop: '0', marginBottom: '0',
                    paddingTop: '0', paddingBottom: '0',
                    backgroundColor: 'transparent',
                    textColor: 'inherit',
                    customClasses: '',
                    animations: {
                        enabled: false,
                        preset: 'fadeUp',
                        duration: 1,
                        delay: 0,
                        trigger: 'in-view'
                    }
                }
            };
            this.blocks.push(newBlock);
            this.activeBlockId = newBlock.id;
            this.isDirty = true;
        },
        removeBlock(id) {
            this.blocks = this.blocks.filter(b => b.id !== id);
            if (this.activeBlockId === id) this.activeBlockId = null;
            this.isDirty = true;
        },
        updateBlock(id, payload) {
            const index = this.blocks.findIndex(b => b.id === id);
            if (index !== -1) {
                this.blocks[index] = { ...this.blocks[index], ...payload };
                this.isDirty = true;
            }
        },
        setActiveBlock(id) {
            this.activeBlockId = id;
        },
        moveBlock(id, direction) {
            const index = this.blocks.findIndex(b => b.id === id);
            if (index < 0) return;

            if (direction === 'up' && index > 0) {
                const temp = this.blocks[index];
                this.blocks[index] = this.blocks[index - 1];
                this.blocks[index - 1] = temp;
                this.isDirty = true;
            } else if (direction === 'down' && index < this.blocks.length - 1) {
                const temp = this.blocks[index];
                this.blocks[index] = this.blocks[index + 1];
                this.blocks[index + 1] = temp;
                this.isDirty = true;
            }
        }
    },
    getters: {
        activeBlock: (state) => state.blocks.find(b => b.id === state.activeBlockId),
    }
});
