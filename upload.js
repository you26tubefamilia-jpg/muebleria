import fs from 'fs';
import path from 'path';

const API_URL = 'https://api.baserow.io/api';
const TOKEN = 'x9J9whZ3kqMsb8eqhORWsh2gq15z8r4h';
const TABLE_ID = 1007645;

async function uploadFile(filePath) {
    const fileContent = fs.readFileSync(filePath);
    const blob = new Blob([fileContent], { type: 'image/jpeg' });
    const formData = new FormData();
    formData.append('file', blob, path.basename(filePath));

    const response = await fetch(`${API_URL}/user-files/upload-file/`, {
        method: 'POST',
        headers: {
            'Authorization': `Token ${TOKEN}`
        },
        body: formData
    });

    return await response.json();
}

async function main() {
    const result = await uploadFile('camas/024472c3165e27a2c4589a89d64887dd.jpg');
    console.log(result);
}

main().catch(console.error);
