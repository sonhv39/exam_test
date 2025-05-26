// Export functions
export function showPreview(event) {
    console.log('showPreview function called');
    event.preventDefault();
    const form = document.getElementById('editHotelForm');
    console.log('Form found:', form);
    const formData = new FormData(form);
    
    // Get selected hotel type
    const typeSelect = document.getElementById('hotel_type');
    const selectedType = typeSelect.options[typeSelect.selectedIndex];
    console.log('Selected type:', selectedType);
    console.log('Selected type data:', {
        image: selectedType.dataset.image,
        filePath: selectedType.dataset.filePath
    });
    
    // Get selected prefecture
    const prefectureSelect = document.getElementById('prefecture_id');
    const selectedPrefecture = prefectureSelect.options[prefectureSelect.selectedIndex];
    console.log('Selected prefecture:', selectedPrefecture);
    
    // Update preview content
    document.getElementById('previewName').textContent = formData.get('hotel_name');
    document.getElementById('previewPrefecture').textContent = selectedPrefecture.text;
    document.getElementById('previewType').textContent = selectedType.text;
    document.getElementById('previewDescription').textContent = formData.get('description');
    
    // Handle image preview
    const imageFile = formData.get('hotel_image_file');
    const currentImage = document.querySelector('.current-image img');
    console.log('Current image:', currentImage?.src);
    
    if (imageFile && imageFile.size > 0) {
        console.log('Case 1: New image selected');
        // If new image is selected, show it
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(imageFile);
    } else if (currentImage && currentImage.src && !currentImage.src.includes('default.jpg')) {
        // If no new image and current image is not default, show the current image
        document.getElementById('previewImage').src = currentImage.src;
    } else {
        console.log('Case 3: Using default image');
        // If no image or current image is default, show the file_path image
        const filePath = selectedType.dataset.filePath;
        
        if (filePath) {
            document.getElementById('previewImage').src = filePath;
        } else {
            document.getElementById('previewImage').src = selectedType.dataset.image;
        }
    }
    
    // Show modal
    const modal = document.getElementById('previewModal');
    console.log('Modal element:', modal);
    modal.style.display = 'flex';
}

export function closePreview() {
    console.log('closePreview function called');
    document.getElementById('previewModal').style.display = 'none';
}

export function previewImage(input) {
    console.log('previewImage function called');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.current-image img');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

export function initHotelEdit() {
    console.log('initHotelEdit function called');
    const form = document.getElementById('editHotelForm');
    console.log('Form element:', form);
    const imageInput = document.getElementById('hotel_image_file');
    console.log('Image input element:', imageInput);

    // Handle form submission
    form.addEventListener('submit', function(event) {
        console.log('Form submit event triggered');
        event.preventDefault(); // Prevent form submission
        showPreview(event);
    });

    // Handle image preview
    imageInput.addEventListener('change', function(event) {
        previewImage(event.target);
    });

    // Handle update button click
    const updateButton = document.querySelector('.modal-content .btn-submit');
    if (updateButton) {
        updateButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default action
            const form = document.getElementById('editHotelForm');
            const formData = new FormData(form);
            
            // Ensure hotel_id is included
            const hotelIdInput = form.querySelector('input[name="hotel_id"]');
            if (!hotelIdInput) {
                console.error('Hotel ID input not found in form');
                alert('Hotel ID is missing. Please try again.');
                return;
            }
            
            const hotelId = hotelIdInput.value;
            if (!hotelId) {
                console.error('Hotel ID value is empty');
                alert('Hotel ID is missing. Please try again.');
                return;
            }
            
            formData.set('hotel_id', hotelId);

            // Handle hotel image file
            const imageInput = document.getElementById('hotel_image_file');
            if (imageInput && imageInput.files && imageInput.files[0]) {
                formData.set('hotel_image_file', imageInput.files[0]);
            }
            
            console.log('Form data:', {
                hotel_id: formData.get('hotel_id'),
                hotel_name: formData.get('hotel_name'),
                prefecture_id: formData.get('prefecture_id'),
                hotel_type: formData.get('hotel_type'),
                description: formData.get('description'),
                hotel_image_file: formData.get('hotel_image_file') ? 'File selected' : 'No file'
            });

            // Submit form using fetch
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (!response.ok) {
                    // Try to get error message from response
                    let errorMessage = 'Network response was not ok';
                    if (contentType && contentType.includes('application/json')) {
                        const errorData = await response.json();
                        errorMessage = errorData.message || errorMessage;
                    }
                    throw new Error(errorMessage);
                }
                
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                }
                throw new Error('Invalid response format');
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Error updating hotel: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error updating hotel: ' + error.message);
            });
        });
    }

    // Make functions available globally
    window.showPreview = showPreview;
    window.closePreview = closePreview;
    window.previewImage = previewImage;
} 