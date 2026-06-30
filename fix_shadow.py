import os
import re

directory = 'resources/views'

for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r') as f:
                content = f.read()
                
            original_content = content
            # Replace the weird blue shadow with a standard large shadow
            content = content.replace('shadow-[0_0_15px_rgba(93,176,229,0.4)]', 'shadow-2xl')
                
            if content != original_content:
                with open(filepath, 'w') as f:
                    f.write(content)
                print(f"Fixed shadow in {filepath}")
