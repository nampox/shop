document.addEventListener('DOMContentLoaded', function() {
    const dropdownMegaList = document.querySelectorAll('.dropdown-mega');
    const isMobile = window.innerWidth <= 991;
    
    dropdownMegaList.forEach(dropdownMega => {
        const dropdownLink = dropdownMega.querySelector('.nav-link');
        const dropdownContent = dropdownMega.querySelector('.dropdown-content');
        const isSearchDropdown = dropdownMega.getAttribute('data-dropdown') === 'search';
        const isBagDropdown = dropdownMega.getAttribute('data-dropdown') === 'bag';
        const isClickDropdown = isSearchDropdown || isBagDropdown;
        
        let timeout;
        let hasAnimated = false;
        
        function showDropdown(isInitial = false) {
            clearTimeout(timeout);
            
            // Chỉ trigger animation khi lần đầu tiên mở
            if (isInitial && !hasAnimated) {
                const items = dropdownContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                items.forEach(item => {
                    const delay = item.getAttribute('data-animation-delay') || '0.1';
                    item.style.animation = 'none';
                    void item.offsetWidth;
                    item.style.animation = `fadeInLeft 0.4s ease ${delay}s forwards`;
                });
                hasAnimated = true;
            }
            
            dropdownContent.style.opacity = '1';
            dropdownContent.style.visibility = 'visible';
            if (!isMobile) {
                dropdownContent.style.transform = 'translateY(0)';
            }
        }
        
        function hideDropdown() {
            timeout = setTimeout(() => {
                dropdownContent.style.opacity = '0';
                dropdownContent.style.visibility = 'hidden';
                if (!isMobile) {
                    dropdownContent.style.transform = 'translateY(-20px)';
                }
                
                // Reset items để có thể animate lại lần sau
                const items = dropdownContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                items.forEach(item => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-20px)';
                    item.style.animation = 'none';
                });
                
                hasAnimated = false; // Reset flag
            }, 200);
        }
        
        // Trên mobile dùng click
        if (isMobile) {
            dropdownLink.addEventListener('click', (e) => {
                e.preventDefault();
                const isVisible = dropdownContent.classList.contains('show');
                
                // Đóng tất cả dropdown khác và reset state
                dropdownMegaList.forEach(other => {
                    if (other !== dropdownMega) {
                        const otherContent = other.querySelector('.dropdown-content');
                        otherContent.classList.remove('show');
                        otherContent.style.visibility = 'hidden';
                        otherContent.style.opacity = '0';
                        
                        // Reset items của dropdown khác
                        const otherItems = otherContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                        otherItems.forEach(item => {
                            item.style.opacity = '0';
                            item.style.transform = 'translateX(-20px)';
                            item.style.animation = 'none';
                        });
                    }
                });
                
                if (isVisible) {
                    dropdownContent.classList.remove('show');
                    setTimeout(() => {
                        dropdownContent.style.visibility = 'hidden';
                        dropdownContent.style.opacity = '0';
                    }, 300);
                    hasAnimated = false;
                } else {
                    dropdownContent.classList.add('show');
                    
                    // Reset và trigger animation
                    const items = dropdownContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                    items.forEach(item => {
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(-20px)';
                        item.style.animation = 'none';
                    });
                    
                    hasAnimated = false;
                    // Trigger animation sau một chút để có thời gian show class
                    setTimeout(() => {
                        items.forEach(item => {
                            const delay = item.getAttribute('data-animation-delay') || '0.1';
                            item.style.animation = 'none';
                            void item.offsetWidth;
                            item.style.animation = `fadeInLeft 0.4s ease ${delay}s forwards`;
                        });
                        hasAnimated = true;
                    }, 50);
                    
                    dropdownContent.style.visibility = 'visible';
                    dropdownContent.style.opacity = '1';
                }
            });
        } else {
            // Trên desktop
            if (isClickDropdown) {
                // Search và Bag dropdown dùng click ngay cả trên desktop
                dropdownLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isVisible = dropdownContent.style.visibility === 'visible';
                    
                    // Đóng tất cả dropdown khác
                    dropdownMegaList.forEach(other => {
                        if (other !== dropdownMega) {
                            const otherContent = other.querySelector('.dropdown-content');
                            otherContent.style.opacity = '0';
                            otherContent.style.visibility = 'hidden';
                            otherContent.style.transform = 'translateY(-20px)';
                            
                            const otherItems = otherContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                            otherItems.forEach(item => {
                                item.style.opacity = '0';
                                item.style.transform = 'translateX(-20px)';
                                item.style.animation = 'none';
                            });
                        }
                    });
                    
                    if (isVisible) {
                        hideDropdown();
                    } else {
                        // Reset animation state trước khi show
                        hasAnimated = false;
                        
                        // Reset items
                        const items = dropdownContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                        items.forEach(item => {
                            item.style.opacity = '0';
                            item.style.transform = 'translateX(-20px)';
                            item.style.animation = 'none';
                        });
                        
                        // Show và trigger animation
                        dropdownContent.style.opacity = '1';
                        dropdownContent.style.visibility = 'visible';
                        dropdownContent.style.transform = 'translateY(0)';
                        
                        // Trigger animation sau một chút
                        setTimeout(() => {
                            items.forEach(item => {
                                const delay = item.getAttribute('data-animation-delay') || '0.1';
                                item.style.animation = 'none';
                                void item.offsetWidth;
                                item.style.animation = `fadeInLeft 0.4s ease ${delay}s forwards`;
                            });
                            hasAnimated = true;
                        }, 50);
                        
                        // Focus vào input nếu là search dropdown
                        if (isSearchDropdown) {
                            setTimeout(() => {
                                const searchInput = dropdownContent.querySelector('.search-input');
                                if (searchInput) {
                                    searchInput.focus();
                                }
                            }, 250);
                        }
                    }
                });
                
                // Đóng khi click ra ngoài hoặc press Escape
                document.addEventListener('click', (e) => {
                    if (!dropdownMega.contains(e.target) && dropdownContent.style.visibility === 'visible') {
                        hideDropdown();
                    }
                });
            } else {
                // Các dropdown khác dùng hover - chỉ khi hover vào nav-item
                dropdownLink.addEventListener('mouseenter', () => {
                    // Đóng tất cả dropdown khác
                    dropdownMegaList.forEach(other => {
                        if (other !== dropdownMega) {
                            const otherContent = other.querySelector('.dropdown-content');
                            otherContent.style.opacity = '0';
                            otherContent.style.visibility = 'hidden';
                            otherContent.style.transform = 'translateY(-20px)';
                            
                            const otherItems = otherContent.querySelectorAll('.dropdown-heading, .dropdown-item');
                            otherItems.forEach(item => {
                                item.style.opacity = '0';
                                item.style.transform = 'translateX(-20px)';
                                item.style.animation = 'none';
                            });
                        }
                    });
                    
                    showDropdown(true);
                });
                
                dropdownMega.addEventListener('mouseleave', hideDropdown);
            }
        }
    });
});
