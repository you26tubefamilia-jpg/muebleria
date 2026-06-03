const fs = require('fs');
const path = require('path');

const dir = 'c:/xampp/htdocs/muebleria/resources/views';

function walk(dir) {
    fs.readdirSync(dir).forEach(file => {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            walk(fullPath);
        } else if (fullPath.endsWith('.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            if (content.includes('Mueblería Panamá')) {
                content = content.replace(/Mueblería Panamá/g, 'Muebles Panamá');
                fs.writeFileSync(fullPath, content);
                console.log('Updated', fullPath);
            }
        }
    });
}

walk(dir);
