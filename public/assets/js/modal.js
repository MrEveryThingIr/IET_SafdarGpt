function createModal(id, title, content) {
    const modal = document.createElement('div');
    modal.id = id.replace('#', '');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-button" onclick="document.getElementById('${modal.id}').style.display='none'">&times;</span>
            <h2>${title}</h2>
            <form method="POST" action="/add_block.php">
                ${content}
                <input type="hidden" name="block_type" value="${title.toLowerCase().replace(' add ', '')}">
                <input type="submit" value="Add ${title}">
            </form>
        </div>
    `;
    document.body.appendChild(modal);
}

// addEventListener('click',)
createModal('#addHeadingModal', 'Add Heading', `
    <label>Content:</label><br>
    <input type="text" name="content" required><br>
    <label>Heading Level:</label>
    <select name="heading_level">
        <option value="1">H1</option>
        <option value="2">H2</option>
        <option value="3">H3</option>
        <option value="4">H4</option>
        <option value="5">H5</option>
        <option value="6">H6</option>
    </select><br>
`);


createModal('#addParagraphModal', 'Add Paragraph', `
    <label>Content:</label><br>
    <textarea name="content" required></textarea><br>
`);


createModal('#addImageModal', 'Add Image', `
    <label>Image URL:</label><br>
    <input type="url" name="image_url" required><br>
    <label>Alt Text:</label><br>
    <input type="text" name="image_alt"><br>
    <label>Caption:</label><br>
    <input type="text" name="image_caption"><br>
`);


createModal('#addAudioModal', 'Add Audio', `
    <label>Audio Embed URL or File URL:</label><br>
    <input type="url" name="content" required><br>
`);



createModal('#addVideoModal', 'Add Video', `
    <label>Video Embed URL or File URL:</label><br>
    <input type="url" name="content" required><br>
`);



createModal('#addListModal', 'Add List', `
    <label>List Type:</label>
    <select name="list_type" required>
        <option value="unordered">Unordered</option>
        <option value="ordered">Ordered</option>
    </select><br>
    <label>List Items (one per line):</label><br>
    <textarea name="content" required></textarea><br>
`);


createModal('#addQuoteModal', 'Add Quote', `
    <label>Quote Text:</label><br>
    <textarea name="content" required></textarea><br>
`);

createModal('#addDividerModal', 'Add Divider', `
    <p>No content needed for divider.</p>
`);



createModal('#addEmbedModal', 'Add Embed', `
    <label>Embed Code or URL:</label><br>
    <textarea name="content" required></textarea><br>
`);



createModal('#addCtaModal', 'Add CTA', `
    <label>Button Text:</label><br>
    <input type="text" name="content" required><br>
    <label>Link URL:</label><br>
    <input type="url" name="additional_data[link_url]" required><br>
`);



createModal('#addFaqModal', 'Add FAQ', `
    <label>Question:</label><br>
    <input type="text" name="content" required><br>
    <label>Answer:</label><br>
    <textarea name="additional_data[answer]" required></textarea><br>
`);



createModal('#addSectionModal', 'Add Section', `
    <label>Heading Text:</label><br>
    <input type="text" name="additional_data[heading]" required><br>
    <label>Heading Level:</label>
    <select name="additional_data[heading_level]">
        <option value="1">H1</option>
        <option value="2">H2</option>
        <option value="3">H3</option>
    </select><br>
    <label>Paragraph Text:</label><br>
    <textarea name="additional_data[paragraph]" required></textarea><br>
`);
