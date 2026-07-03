window.avatarCropper = function(config) {
            return {
                inputId: config.inputId,
                inputName: config.inputName,
                alpineImage: config.alpineImage,
                initialImage: config.initialImage,
                pdpPreview: null,
                delete_pdp: false,
                
                showAvatarMenu: false,
                showWebcamModal: false,
                showCropModal: false,
                webcamStream: null,
                cropImageUrl: null,
                cropper: null,

                initComponent() {
                    // Watch for external changes if connected to a parent Alpine state
                    this.$watch('alpineImage', value => {
                        this.alpineImage = value;
                    });
                },

                displayImage() {
                    if (this.pdpPreview) return this.pdpPreview;
                    if (this.alpineImage) return this.alpineImage;
                    if (this.initialImage && !this.delete_pdp) return this.initialImage;
                    return null;
                },

                async openWebcam() {
                    this.showAvatarMenu = false;
                    try {
                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            window.dispatchEvent(new CustomEvent('open-alert', { detail: { title: 'Erreur', message: "La webcam n'est pas supportée.", type: 'alert' } }));
                            return;
                        }
                        this.webcamStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                        this.showWebcamModal = true;
                        this.$nextTick(() => {
                            this.$refs.webcamVideo.srcObject = this.webcamStream;
                        });
                    } catch (err) {
                        window.dispatchEvent(new CustomEvent('open-alert', { detail: { title: 'Erreur', message: "Impossible d'accéder à la webcam.", type: 'alert' } }));
                    }
                },
                closeWebcam() {
                    this.showWebcamModal = false;
                    if (this.webcamStream) {
                        this.webcamStream.getTracks().forEach(track => track.stop());
                        this.webcamStream = null;
                    }
                    if (this.$refs.webcamVideo) {
                        this.$refs.webcamVideo.srcObject = null;
                    }
                },
                captureWebcam() {
                    const video = this.$refs.webcamVideo;
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.translate(canvas.width, 0);
                    ctx.scale(-1, 1);
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    this.cropImageUrl = canvas.toDataURL('image/jpeg', 1.0);
                    this.closeWebcam();
                    this.showCropModal = true;
                    this.initCropper();
                },
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.cropImageUrl = URL.createObjectURL(file);
                        this.showCropModal = true;
                        this.initCropper();
                        event.target.value = '';
                    }
                },
                initCropper() {
                    this.$nextTick(() => {
                        const image = document.getElementById('cropperImageComponent');
                        image.onload = () => {
                            if (this.cropper) {
                                this.cropper.destroy();
                            }
                            this.cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 1,
                                restore: false,
                                guides: true,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                                toggleDragModeOnDblclick: false,
                            });
                        };
                        // En cas de cache
                        if(image.complete) image.onload();
                    });
                },
                closeCropModal() {
                    this.showCropModal = false;
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.cropImageUrl = null;
                },
                confirmCrop() {
                    if (!this.cropper) return;
                    this.cropper.getCroppedCanvas({
                        width: 400,
                        height: 400
                    }).toBlob((blob) => {
                        const file = new File([blob], "avatar.jpg", { type: "image/jpeg" });
                        this.pdpPreview = URL.createObjectURL(blob);
                        this.delete_pdp = false;
                        
                        // Injection dans l'input file caché via DataTransfer
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        const fileInput = document.getElementById(this.inputId);
                        if(fileInput) {
                            fileInput.files = dataTransfer.files;
                            // Dispatch event if parent listens
                            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }

                        // Fire a custom event for Alpine parents
                        this.$dispatch('avatar-changed', { file: file, preview: this.pdpPreview });

                        this.closeCropModal();
                    }, 'image/jpeg', 0.9);
                },
                deleteProfilePicture() {
                    window.dispatchEvent(new CustomEvent('open-alert', {
                        detail: {
                            title: 'Confirmation',
                            message: "Voulez-vous vraiment supprimer votre photo ?",
                            type: 'confirm',
                            onConfirm: () => {
                                this.pdpPreview = null;
                                this.delete_pdp = true;
                                
                                const fileInput = document.getElementById(this.inputId);
                                if(fileInput) {
                                    fileInput.value = '';
                                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                                }

                                this.$dispatch('avatar-deleted');
                            }
                        }
                    }));
                }
            }
        }