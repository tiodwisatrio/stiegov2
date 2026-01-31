<!-- Toast Notification Container -->
<div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; max-width: 380px; display: flex; flex-direction: column; gap: 0.5rem;">
    <!-- Toast notifications will be inserted here -->
</div>

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    @keyframes progress {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }

    .toast-enter {
        animation: slideInRight 0.3s ease-out forwards;
    }

    .toast-exit {
        animation: slideOutRight 0.3s ease-in forwards;
    }

    .toast-progress {
        animation: progress 5s linear forwards;
    }
</style>

<script>
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-enter bg-white rounded-lg shadow-xl overflow-hidden';
    
    // Set colors based on type with inline styles for better control
    let borderStyle, bgColor, textColor, iconColor, progressColor, icon;
    switch(type) {
        case 'success':
            borderStyle = 'border-left: 4px solid #16a34a;';
            bgColor = 'background-color: #f0fdf4;';
            textColor = 'color: #15803d;';
            iconColor = '#16a34a';
            progressColor = '#16a34a';
            icon = `<svg class="w-6 h-6" style="color: ${iconColor};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`;
            break;
        case 'error':
            borderStyle = 'border-left: 4px solid #800020;';
            bgColor = 'background-color: #fef2f2;';
            textColor = 'color: #800020; font-weight: 600;';
            iconColor = '#800020';
            progressColor = '#800020';
            icon = `<svg class="w-6 h-6" style="color: ${iconColor};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`;
            break;
        case 'warning':
            borderStyle = 'border-left: 4px solid #ca8a04;';
            bgColor = 'background-color: #fefce8;';
            textColor = 'color: #854d0e;';
            iconColor = '#ca8a04';
            progressColor = '#ca8a04';
            icon = `<svg class="w-6 h-6" style="color: ${iconColor};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>`;
            break;
        case 'info':
            borderStyle = 'border-left: 4px solid #2563eb;';
            bgColor = 'background-color: #eff6ff;';
            textColor = 'color: #1e40af;';
            iconColor = '#2563eb';
            progressColor = '#2563eb';
            icon = `<svg class="w-6 h-6" style="color: ${iconColor};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`;
            break;
    }
    
    toast.style.cssText = borderStyle;
    
    toast.innerHTML = `
        <div class="flex items-start p-4 gap-3">
            <div class="flex-shrink-0">
                ${icon}
            </div>
            <div class="flex-1 min-w-0">
                <p style="${textColor} font-size: 0.875rem;">${message}</p>
            </div>
            <button onclick="closeToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div style="height: 4px; ${bgColor}">
            <div class="toast-progress" style="height: 100%; background-color: ${progressColor};"></div>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        closeToast(toast.querySelector('button'));
    }, 5000);
}

function closeToast(button) {
    const toast = button.closest('.toast-enter');
    if (toast) {
        toast.classList.remove('toast-enter');
        toast.classList.add('toast-exit');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

// Check for Laravel session messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    
    @if(session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
    
    @if(session('warning'))
        showToast("{{ session('warning') }}", 'warning');
    @endif
    
    @if(session('info'))
        showToast("{{ session('info') }}", 'info');
    @endif
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast("{{ $error }}", 'error');
        @endforeach
    @endif
});
</script>
