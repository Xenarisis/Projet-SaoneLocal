import os
import re

directory = 'resources/views'

replacements = [
    # Colors
    (r'\bcool-green\b', 'base-green'),
    (r'\bdark-gray\b', 'dark'),
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
            
            # For light-gray, we distinguish based on file name or context
            # #dcdcdc was used in auth-like files: login, register, logout, profile, complete-profile
            if 'users/' in filepath:
                content = re.sub(r'\blight-gray\b', 'gray-200', content)
            else:
                content = re.sub(r'\blight-gray\b', 'base-gray', content)
                
            if content != original_content:
                with open(filepath, 'w') as f:
                    f.write(content)
                print(f"Fixed {filepath}")

