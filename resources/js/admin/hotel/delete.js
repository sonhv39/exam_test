let currentHotelId = null;

export function initHotelDelete() {
    console.log('Initializing hotel delete functionality');
    
    // Get modal elements
    const modal = document.getElementById('deleteModal');
    const cancelButton = document.getElementById('cancelDelete');
    const confirmButton = document.getElementById('confirmDelete');
    
    // Add click event listener to all delete buttons
    const deleteButtons = document.querySelectorAll('.btn-delete');
    console.log('Found delete buttons:', deleteButtons.length);
    
    // Remove any existing event listeners
    deleteButtons.forEach(button => {
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
    });

    // Add new event listeners
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.onclick = function(event) {
            console.log('Delete button clicked');
            event.preventDefault();
            event.stopPropagation();
            currentHotelId = this.dataset.hotelId;
            console.log('Current hotel ID:', currentHotelId);
            showModal();
        };
    });

    // Handle cancel button click
    if (cancelButton) {
        cancelButton.onclick = function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Cancel button clicked');
            hideModal();
        };
    }

    // Handle confirm button click
    if (confirmButton) {
        confirmButton.onclick = function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Confirm button clicked');
            if (currentHotelId) {
                deleteHotel(currentHotelId);
            }
            hideModal();
        };
    }

    // Close modal when clicking outside
    if (modal) {
        modal.onclick = function(event) {
            if (event.target === modal) {
                hideModal();
            }
        };
    }
}

function showModal() {
    console.log('Showing modal');
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function hideModal() {
    console.log('Hiding modal');
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
    currentHotelId = null;
}

function deleteHotel(hotelId) {
    console.log('Deleting hotel:', hotelId);
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    // Send delete request
    fetch(`/admin/hotel/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ hotel_id: hotelId })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Delete response:', data);
        if (data.success) {
            // Remove the hotel row from the table
            const hotelRow = document.querySelector(`tr[data-hotel-id="${hotelId}"]`);
            if (hotelRow) {
                hotelRow.remove();
            }
            alert('Hotel deleted successfully');
        } else {
            alert('Error deleting hotel: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting hotel. Please try again.');
    });
} 