import './bootstrap';
import { initHotelEdit } from './admin/hotel/edit';

// Initialize components when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize hotel edit if the form exists
    const editForm = document.getElementById('editHotelForm');
    if (editForm) {
        initHotelEdit();
    }
});