import fs from 'fs';
import path from 'path';

const API_URL = 'https://api.baserow.io/api';
const TOKEN = 'x9J9whZ3kqMsb8eqhORWsh2gq15z8r4h';
const TABLE_ID = 1007645;

const folders = ['camas', 'cocina', 'comedores', 'gaveteros', 'puertas'];

async function uploadFile(filePath) {
    const fileContent = fs.readFileSync(filePath);
    let mimeType = 'image/jpeg';
    if (filePath.toLowerCase().endsWith('.png')) mimeType = 'image/png';
    else if (filePath.toLowerCase().endsWith('.webp')) mimeType = 'image/webp';
    
    const blob = new Blob([fileContent], { type: mimeType });
    const formData = new FormData();
    formData.append('file', blob, path.basename(filePath));

    const response = await fetch(`${API_URL}/user-files/upload-file/`, {
        method: 'POST',
        headers: {
            'Authorization': `Token ${TOKEN}`
        },
        body: formData
    });

    if (!response.ok) {
        const errText = await response.text();
        throw new Error(`Upload failed for ${filePath}: ${response.status} ${errText}`);
    }

    return await response.json();
}

async function createRow(nombre, notas, activo) {
    const response = await fetch(`${API_URL}/database/rows/table/${TABLE_ID}/?user_field_names=true`, {
        method: 'POST',
        headers: {
            'Authorization': `Token ${TOKEN}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "Nombre": nombre,
            "Notas": notas,
            "Activo": activo
        })
    });

    if (!response.ok) {
        const errText = await response.text();
        throw new Error(`Create row failed for ${nombre}: ${response.status} ${errText}`);
    }

    return await response.json();
}

async function main() {
    for (const folder of folders) {
        if (!fs.existsSync(folder)) continue;
        const files = fs.readdirSync(folder);
        for (const file of files) {
            const ext = path.extname(file).toLowerCase();
            if (!['.jpg', '.jpeg', '.png', '.webp'].includes(ext)) continue;
            
            const filePath = path.join(folder, file);
            console.log(`Processing ${filePath}...`);
            try {
                const uploadResult = await uploadFile(filePath);
                const url = uploadResult.url;
                
                const nombre = `${folder}/${file}`;
                await createRow(nombre, url, true);
                console.log(`Success: ${nombre}`);
                
                // Add a small delay to avoid rate limits
                await new Promise(res => setTimeout(res, 500));
            } catch (err) {
                console.error(`Error processing ${filePath}:`, err.message);
            }
        }
    }
    console.log("Finished all uploads.");
}

main().catch(console.error);
