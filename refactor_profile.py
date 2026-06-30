import re

with open('resources/views/users/profile.blade.php', 'r') as f:
    content = f.read()

# Remove the three modals (Crop, Menu, Webcam)
content = re.sub(r'<div x-show="showCropModal".*?</div>\s*</div>\s*</div>', '', content, flags=re.DOTALL)
content = re.sub(r'<div x-show="showAvatarMenu".*?</div>\s*</div>\s*</div>', '', content, flags=re.DOTALL)
content = re.sub(r'<div x-show="showWebcamModal".*?</div>\s*</div>\s*</div>', '', content, flags=re.DOTALL)

# Replace the avatar button with the component
old_button = r'<div class="absolute -top-12 flex items-center justify-center gap-4">.*?</button>\s*</div>'
new_button = r'''<div class="absolute -top-12 flex items-center justify-center gap-4 w-full">
                <x-avatar-cropper alpineImage="user?.pdp" @avatar-changed="debouncedSave" @avatar-deleted="debouncedSave" />
            </div>'''
content = re.sub(old_button, new_button, content, flags=re.DOTALL)

# Remove the alpine methods and state
methods_to_remove = [
    r'showCropModal: false,\s*',
    r'cropImageUrl: null,\s*',
    r'cropper: null,\s*',
    r'showAvatarMenu: false,\s*',
    r'showWebcamModal: false,\s*',
    r'webcamStream: null,\s*',
    r'delete_pdp: false,\s*',
    r'pdpFile: null,\s*',
    r'pdpPreview: null,\s*',
    r'deleteProfilePicture\(\) \{.*?\},\s*(?=async openWebcam)',
    r'async openWebcam\(\) \{.*?\},\s*(?=closeWebcam)',
    r'closeWebcam\(\) \{.*?\},\s*(?=captureWebcam)',
    r'captureWebcam\(\) \{.*?\},\s*(?=handleFileChange)',
    r'handleFileChange\(event\) \{.*?\},\s*(?=closeCropModal)',
    r'closeCropModal\(\) \{.*?\},\s*(?=confirmCrop)',
    r'confirmCrop\(\) \{.*?\},\s*(?=debouncedSave)',
]

for method in methods_to_remove:
    content = re.sub(method, '', content, flags=re.DOTALL)

# Update saveProfile
old_save_profile = r"if \(this\.pdpFile\) \{\s*formData\.append\('pdp', this\.pdpFile\);\s*\}\s*if \(this\.delete_pdp\) \{\s*formData\.append\('delete_pdp', 1\);\s*\}"
new_save_profile = r"""const pdpInput = document.getElementById('pdp_path');
                        if (pdpInput && pdpInput.files.length > 0) {
                            formData.append('pdp', pdpInput.files[0]);
                        }
                        const deleteInput = document.querySelector('input[name="delete_pdp_path"]');
                        if (deleteInput && deleteInput.value === '1') {
                            formData.append('delete_pdp', 1);
                        }"""
content = re.sub(old_save_profile, new_save_profile, content, flags=re.DOTALL)

# Update the reset of pdpFile and delete_pdp in saveProfile success block
old_reset = r"this\.pdpFile = null;\s*this\.delete_pdp = false;"
new_reset = r""
content = re.sub(old_reset, new_reset, content, flags=re.DOTALL)


with open('resources/views/users/profile.blade.php', 'w') as f:
    f.write(content)

print("Profile updated successfully")
