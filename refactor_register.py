import re

with open('resources/views/users/register.blade.php', 'r') as f:
    content = f.read()

# Add Cropper JS & CSS
if 'cropperjs' not in content:
    old_top = r'<x-layouts.app title="Inscription">'
    new_top = r'''<x-layouts.app title="Inscription">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>'''
    content = re.sub(old_top, new_top, content)

# Replace the file input with the new component
old_input = r'<div class="flex justify-center w-full mt-2">.*?</x-icon-pill-input>\s*</div>\s*</div>'
new_input = r'''<div class="flex justify-center w-full mt-2 mb-4">
                    <div class="w-full flex flex-col items-center gap-1.5">
                        <span class="text-white text-sm font-semibold tracking-wide text-center mb-10">Photo de profil (optionnel)</span>
                        <x-avatar-cropper inputId="pdp_path" inputName="pdp_path" />
                    </div>
                </div>'''

content = re.sub(old_input, new_input, content, flags=re.DOTALL)

with open('resources/views/users/register.blade.php', 'w') as f:
    f.write(content)

print("Register updated successfully")
