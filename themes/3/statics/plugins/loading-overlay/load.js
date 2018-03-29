function loadding (action) {
        if (action=='load') {
            $('#target').loadingOverlay({
              loadingClass: 'loading',          // Class added to target while loading
              overlayClass: 'loading-overlay',  // Class added to overlay (style with CSS)
              spinnerClass: 'loading-spinner',  // Class added to loading overlay spinner
              iconClass: 'loading-icon',        // Class added to loading overlay spinner
              textClass: 'loading-text',        // Class added to loading overlay spinner
              loadingText: 'Vui lòng đợi'            // Text within loading overlay
            });
            
        }else if(action=='remove'){
            $('#target').loadingOverlay('remove', {
              loadingClass: 'loading',
              overlayClass: 'loading-overlay'
            });
        }
    }
