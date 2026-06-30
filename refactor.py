import os
import re

directory = 'resources/views'

replacements = [
    # Colors
    (r'\[#057941\]', 'cool-green'),
    (r'\[#2A0F06\]', 'cachou'),
    (r'\[#2a0f06\]', 'cachou'),
    (r'\[#2E0B0B\]', 'cachou'), # similar to cachou
    (r'\[#046134\]', 'pine-green'), # similar to pine-green
    (r'\[#5db0e5\]', 'info'),
    (r'\[#dcdcdc\]', 'light-gray'),
    (r'\[#DEDEDE\]', 'light-gray'),
    (r'\[#1b1b18\]', 'dark-gray'),
    (r'\[#1B1B18\]', 'dark-gray'),
    (r'\[#820606\]', 'red-blood'),
    
    # Fonts
    # We'll replace font-sans with font-body
    (r'\bfont-sans\b', 'font-body'),
]

for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r') as f:
                content = f.read()
                
            original_content = content
            for pattern, repl in replacements:
                content = re.sub(pattern, repl, content)
            
            # Additional logic for headings
            # Replace class="... font-bold ..." with "font-title" on h1, h2, h3 tags
            # Actually, the user asked to replace font families.
            
            if content != original_content:
                with open(filepath, 'w') as f:
                    f.write(content)
                print(f"Updated {filepath}")

