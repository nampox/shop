/**
 * Multi-Select Component with Search
 * Base component for reusable multi-select dropdowns
 */
class MultiSelect {
    constructor(element, options = {}) {
        this.element = element;
        this.options = {
            placeholder: options.placeholder || 'Chọn...',
            searchPlaceholder: options.searchPlaceholder || 'Tìm kiếm...',
            allowClear: options.allowClear !== false,
            ...options
        };
        
        this.selectedValues = new Set();
        this.allOptions = [];
        this.filteredOptions = [];
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        // Get initial selected values
        const initialValues = this.element.value ? this.element.value.split(',').map(v => v.trim()) : [];
        initialValues.forEach(v => {
            if (v) this.selectedValues.add(v);
        });
        
        // Get all options from select element
        Array.from(this.element.options).forEach(option => {
            if (option.value) {
                this.allOptions.push({
                    value: option.value,
                    label: option.text,
                    selected: this.selectedValues.has(option.value)
                });
            }
        });
        
        this.filteredOptions = [...this.allOptions];
        
        // Hide original select
        this.element.style.display = 'none';
        
        // Create wrapper
        this.createWrapper();
        
        // Bind events
        this.bindEvents();
        
        // Update display
        this.updateDisplay();
    }
    
    createWrapper() {
        const wrapper = document.createElement('div');
        wrapper.className = 'multi-select-wrapper';
        wrapper.innerHTML = `
            <div class="multi-select-input">
                <span class="placeholder">${this.options.placeholder}</span>
                <div class="selected-tags" style="display: none;"></div>
            </div>
            <div class="multi-select-dropdown">
                <div class="multi-select-search">
                    <input type="text" placeholder="${this.options.searchPlaceholder}" class="search-input">
                </div>
                <div class="multi-select-options"></div>
            </div>
        `;
        
        this.element.parentNode.insertBefore(wrapper, this.element);
        this.wrapper = wrapper;
        this.input = wrapper.querySelector('.multi-select-input');
        this.dropdown = wrapper.querySelector('.multi-select-dropdown');
        this.searchInput = wrapper.querySelector('.search-input');
        this.optionsContainer = wrapper.querySelector('.multi-select-options');
        this.placeholder = wrapper.querySelector('.placeholder');
        this.selectedTags = wrapper.querySelector('.selected-tags');
        
        // Color palette for tags
        this.tagColors = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
            'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
        ];
    }
    
    bindEvents() {
        // Toggle dropdown - but not when clicking on tags
        this.input.addEventListener('click', (e) => {
            // Don't toggle if clicking on a tag or remove button
            if (e.target.closest('.tag') || e.target.closest('.remove')) {
                return;
            }
            e.stopPropagation();
            this.toggle();
        });
        
        // Search
        this.searchInput.addEventListener('input', (e) => {
            this.filter(e.target.value);
        });
        
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!this.wrapper.contains(e.target)) {
                this.close();
            }
        });
        
        // Prevent dropdown close when clicking inside
        this.dropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
    
    filter(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        if (!term) {
            this.filteredOptions = [...this.allOptions];
        } else {
            this.filteredOptions = this.allOptions.filter(option =>
                option.label.toLowerCase().includes(term)
            );
        }
        this.renderOptions();
    }
    
    renderOptions() {
        if (this.filteredOptions.length === 0) {
            this.optionsContainer.innerHTML = `
                <div class="multi-select-empty">
                    <i class="bi bi-search"></i> Không tìm thấy kết quả
                </div>
            `;
            return;
        }
        
        this.optionsContainer.innerHTML = this.filteredOptions.map(option => {
            const isSelected = this.selectedValues.has(option.value);
            return `
                <div class="multi-select-option ${isSelected ? 'selected' : ''}" data-value="${option.value}">
                    ${option.label}
                </div>
            `;
        }).join('');
        
        // Bind click events
        this.optionsContainer.querySelectorAll('.multi-select-option').forEach(optionEl => {
            optionEl.addEventListener('click', () => {
                const value = optionEl.dataset.value;
                if (this.selectedValues.has(value)) {
                    this.deselect(value);
                } else {
                    this.select(value);
                }
            });
        });
    }
    
    select(value) {
        this.selectedValues.add(value);
        this.updateOriginalSelect();
        this.updateDisplay();
        this.renderOptions();
    }
    
    deselect(value) {
        this.selectedValues.delete(value);
        this.updateOriginalSelect();
        this.updateDisplay();
        this.renderOptions();
    }
    
    updateOriginalSelect() {
        // Update original select element
        Array.from(this.element.options).forEach(option => {
            option.selected = this.selectedValues.has(option.value);
        });
        
        // Trigger change event
        this.element.dispatchEvent(new Event('change', { bubbles: true }));
    }
    
    updateDisplay() {
        const count = this.selectedValues.size;
        
        if (count === 0) {
            if (this.placeholder) {
                this.placeholder.style.display = 'block';
                this.placeholder.style.visibility = 'visible';
                this.placeholder.style.opacity = '1';
            }
            if (this.selectedTags) {
                this.selectedTags.style.display = 'none';
                this.selectedTags.style.visibility = 'hidden';
                this.selectedTags.style.opacity = '0';
            }
            if (this.placeholder) {
                this.placeholder.textContent = this.options.placeholder;
            }
        } else {
            if (this.placeholder) {
                this.placeholder.style.display = 'none';
                this.placeholder.style.visibility = 'hidden';
                this.placeholder.style.opacity = '0';
            }
            if (this.selectedTags) {
                this.selectedTags.style.display = 'flex';
                this.selectedTags.style.visibility = 'visible';
                this.selectedTags.style.opacity = '1';
            }
            
            // Get selected options
            const selectedOptions = this.allOptions.filter(opt => this.selectedValues.has(opt.value));
            
            // Calculate max width for tags (leave space for "...")
            const inputWidth = this.input.offsetWidth || 300;
            const padding = 32; // left + right padding
            const gap = 8; // gap between tags
            let usedWidth = 0;
            let visibleCount = 0;
            const maxWidth = inputWidth - padding - 30; // 30px for "..."
            
            let tagsHTML = '';
            
            selectedOptions.forEach((option, index) => {
                const colorIndex = index % this.tagColors.length;
                const tagColor = this.tagColors[colorIndex];
                
                // Estimate tag width (rough calculation)
                const tagText = option.label;
                const estimatedWidth = (tagText.length * 8) + 60; // 8px per char + padding + remove button
                
                if (usedWidth + estimatedWidth <= maxWidth || visibleCount === 0) {
                    tagsHTML += `
                        <span class="tag" data-value="${option.value}" style="background: ${tagColor};">
                            ${option.label}
                            <span class="remove" data-value="${option.value}">×</span>
                        </span>
                    `;
                    usedWidth += estimatedWidth + gap;
                    visibleCount++;
                }
            });
            
            // Add "..." if there are more tags
            if (visibleCount < selectedOptions.length) {
                tagsHTML += `<span class="truncate-indicator">...</span>`;
            }
            
            if (this.selectedTags) {
                this.selectedTags.innerHTML = tagsHTML;
                
                // Bind remove button events
                this.selectedTags.querySelectorAll('.remove').forEach(removeBtn => {
                    removeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        const value = removeBtn.dataset.value;
                        if (value) {
                            this.deselect(value);
                        }
                        return false;
                    });
                });
                
                // Prevent dropdown toggle when clicking on tags
                this.selectedTags.querySelectorAll('.tag').forEach(tag => {
                    tag.addEventListener('click', (e) => {
                        // Only prevent if clicking on tag itself, not remove button
                        if (e.target.classList.contains('tag') || e.target.closest('.tag') === tag) {
                            e.stopPropagation();
                        }
                    });
                });
            }
        }
    }
    
    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }
    
    open() {
        this.isOpen = true;
        this.input.classList.add('active');
        this.dropdown.classList.add('show');
        this.searchInput.focus();
        this.renderOptions();
    }
    
    close() {
        this.isOpen = false;
        this.input.classList.remove('active');
        this.dropdown.classList.remove('show');
        this.searchInput.value = '';
        this.filter('');
    }
    
    getSelectedValues() {
        return Array.from(this.selectedValues);
    }
    
    setSelectedValues(values) {
        this.selectedValues.clear();
        values.forEach(v => this.selectedValues.add(String(v)));
        this.updateOriginalSelect();
        this.updateDisplay();
        this.renderOptions();
    }
    
    clear() {
        this.selectedValues.clear();
        this.updateOriginalSelect();
        this.updateDisplay();
        this.renderOptions();
    }
}

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.multi-select').forEach(select => {
        new MultiSelect(select);
    });
});

// Export for manual initialization
if (typeof window !== 'undefined') {
    window.MultiSelect = MultiSelect;
}

