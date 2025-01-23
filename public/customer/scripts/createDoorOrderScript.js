
                                // Get references to the radio buttons and containers
                                const selectDesignRadio = document.getElementById('selectDesign');
                                const inputDesignRadio = document.getElementById('inputDesign');
                                const designOptionsDiv = document.getElementById('design-options');
                                const imageInputDiv = document.getElementById('image-input');
                                const selectedDesign = document.getElementById('selected-design');
                                const designOptions = document.querySelectorAll('.design-option');
                            
                                // Event listener for radio button change
                                document.querySelectorAll('input[name="designChoice"]').forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        if (selectDesignRadio.checked) {
                                            designOptionsDiv.style.display = 'block'; // Show design options
                                            imageInputDiv.style.display = 'none';    // Hide image input
                                        } else if (inputDesignRadio.checked) {
                                            imageInputDiv.style.display = 'block';   // Show image input
                                            designOptionsDiv.style.display = 'none'; // Hide design options
                                        }
                                    });
                                });
                            
                                // Event listener for selecting a design from the image dropdown
                                designOptions.forEach(option => {
                                    option.addEventListener('click', function() {
                                        selectedDesign.src = this.src;  // Set the selected design image
                                    });
                                });


                                const designImageInput = document.getElementById('design-image');
                                const imagePreview = document.getElementById('image-preview');

                                // Listen for changes when the user uploads an image
                                designImageInput.addEventListener('change', function(event) {
                                    const file = event.target.files[0]; // Get the uploaded file
                                    if (file) {
                                        const reader = new FileReader();  // Create a FileReader to read the file
                                        reader.onload = function(e) {
                                            imagePreview.src = e.target.result;  // Set the image src to the uploaded file
                                            imagePreview.style.display = 'block'; // Make the image visible
                                        };
                                        reader.readAsDataURL(file);  // Read the file as a data URL (base64)
                                    }
                                });
                            