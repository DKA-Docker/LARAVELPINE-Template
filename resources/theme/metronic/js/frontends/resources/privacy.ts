/**
 * Component Privacy Policy Logic
 */

const privacyPolicy = {
    init: function () {
        if (!document.querySelector('.frontend-resources')) {
            return;
        }
        this.handleAnimations();
        this.handleInteractions();
    },

    handleAnimations: function () {
        // Re-trigger animations when Livewire updates (if needed)
        document.addEventListener('livewire:navigated', () => {
            const elements = document.querySelectorAll('.animate-fade-up');
            elements.forEach((el) => {
                // Reset animation
                (el as HTMLElement).style.animation = 'none';
                (el as HTMLElement).offsetHeight; /* trigger reflow */
                (el as HTMLElement).style.animation = '';
            });
        });
    },

    handleInteractions: function () {
        console.log('Privacy policy interactions initialized');
        // Any specific JS interactions for privacy policy can go here
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    privacyPolicy.init();
});

export default privacyPolicy;
