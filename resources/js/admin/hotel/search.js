export function initHotelSearch() {
    const searchForm = document.getElementById('searchForm');
    if (!searchForm) return;

    const hotelNameInput = document.querySelector('input[name="hotel_name"]');
    const errorMessage = document.getElementById('errorMessage');

    // Handle form submit
    searchForm.addEventListener('submit', function(event) {
        const hotelName = hotelNameInput.value.trim();
        
        if (!hotelName) {
            event.preventDefault();
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';
        }
    });

    // Handle input change
    hotelNameInput.addEventListener('input', function() {
        if (this.value.trim()) {
            errorMessage.style.display = 'none';
        }
    });
} 