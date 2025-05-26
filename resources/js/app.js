import './bootstrap';
import { initHotelEdit } from './admin/hotel/edit';
import { initHotelDelete } from './admin/hotel/delete';
import { initHotelSearch } from './admin/hotel/search';

// Initialize components when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize hotel edit if the form exists
    const editForm = document.getElementById('editHotelForm');
    if (editForm) {
        initHotelEdit();
    }

    // Initialize hotel delete functionality
    initHotelDelete();

    // Initialize hotel search functionality
    initHotelSearch();
});