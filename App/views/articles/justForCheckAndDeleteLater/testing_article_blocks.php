<?php
$pdo = new PDO("mysql:host=localhost;dbname=your_db", "your_user", "your_password");

$articleId = $_GET['article_id'] ?? 1;

// Fetch all blocks for the given article
$stmt = $pdo->prepare("SELECT * FROM article_blocks WHERE article_id = ? ORDER BY block_order ASC");
$stmt->execute([$articleId]);
$blocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article Editor</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: auto; }
        .block { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; background: #f9f9f9; }
        .form-section { margin-top: 40px; }
    </style>
</head>
<body>

<h1>Article ID: <?= htmlspecialchars($articleId) ?></h1>

<!-- Display existing article blocks -->
<?php foreach ($blocks as $block): ?>
    <div class="block">
        <strong>Type:</strong> <?= htmlspecialchars($block['block_type']) ?><br>
        <?php if ($block['block_type'] === 'heading'): ?>
            <h<?= $block['heading_level'] ?>><?= htmlspecialchars($block['content']) ?></h<?= $block['heading_level'] ?>>
        <?php elseif ($block['block_type'] === 'paragraph'): ?>
            <p><?= nl2br(htmlspecialchars($block['content'])) ?></p>
        <?php elseif ($block['block_type'] === 'image'): ?>
            <img src="<?= htmlspecialchars($block['image_url']) ?>" alt="<?= htmlspecialchars($block['image_alt']) ?>" style="max-width:100%;">
            <p><em><?= htmlspecialchars($block['image_caption']) ?></em></p>
        <?php elseif ($block['block_type'] === 'list'): ?>
            <?php
            $items = json_decode($block['content'], true);
            $listTag = $block['list_type'] === 'ordered' ? 'ol' : 'ul';
            echo "<$listTag>";
            foreach ($items as $item) {
                echo '<li>' . htmlspecialchars($item) . '</li>';
            }
            echo "</$listTag>";
            ?>
        <?php else: ?>
            <div><?= nl2br(htmlspecialchars($block['content'])) ?></div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<!-- Form to create a new article block -->
<div class="form-section">
    <h2>Create New Article Block</h2>
    <form method="post" action="save_block.php">
        <input type="hidden" name="article_id" value="<?= htmlspecialchars($articleId) ?>">
        
        <label for="block_type">Block Type:</label>
        <select name="block_type" id="block_type" required onchange="toggleFields()">
            <option value="">-- Select --</option>
            <option value="paragraph">Paragraph</option>
            <option value="heading">Heading</option>
            <option value="image">Image</option>
            <option value="list">List</option>
            <option value="quote">Quote</option>
            <option value="divider">Divider</option>
            <option value="embed">Embed</option>
            <option value="cta">CTA</option>
            <option value="faq">FAQ</option>
            <option value="video">Video</option>
            <option value="audio">Audio</option>
        </select><br><br>

        <div id="common-fields">
            <label>Order:</label>
            <input type="number" name="block_order" min="0" value="0"><br><br>

            <label>CSS Class (optional):</label>
            <input type="text" name="css_class"><br><br>

            <label>Language:</label>
            <input type="text" name="language_code" value="en"><br><br>
        </div>

        <div id="field-content" style="display:none;">
            <label>Content:</label><br>
            <textarea name="content" rows="4" cols="50"></textarea><br><br>
        </div>

        <div id="field-heading" style="display:none;">
            <label>Heading Level (1–6):</label>
            <input type="number" name="heading_level" min="1" max="6"><br><br>
        </div>

        <div id="field-image" style="display:none;">
            <label>Image URL:</label>
            <input type="text" name="image_url"><br><br>

            <label>Alt Text:</label>
            <input type="text" name="image_alt"><br><br>

            <label>Caption:</label>
            <input type="text" name="image_caption"><br><br>
        </div>

        <div id="field-list" style="display:none;">
            <label>List Type:</label>
            <select name="list_type">
                <option value="unordered">Unordered</option>
                <option value="ordered">Ordered</option>
            </select><br><br>

            <label>List Items (one per line):</label><br>
            <textarea name="list_items" rows="4" cols="50"></textarea><br><br>
        </div>

        <button type="submit">Save Block</button>
    </form>
</div>

<script>
function toggleFields() {
    const type = document.getElementById('block_type').value;
    document.getElementById('field-content').style.display = ['paragraph', 'quote', 'faq', 'cta', 'embed', 'video', 'audio'].includes(type) ? 'block' : 'none';
    document.getElementById('field-heading').style.display = type === 'heading' ? 'block' : 'none';
    document.getElementById('field-image').style.display = type === 'image' ? 'block' : 'none';
    document.getElementById('field-list').style.display = type === 'list' ? 'block' : 'none';
}
</script>

</body>
</html>





--------------------------------------------
article example
--------------------------------------------
<!-- // Sample article data
$article = [
    'title' => 'آموزش ',
    'blocks' => [
        [
            'block_type' => 'heading',
            'content' => 'Introduction to Renewable Energy'
        ],
        [
            'block_type' => 'paragraph',
            'content' => 'Renewable energy sources have become increasingly important in our efforts to combat climate change and reduce dependence on fossil fuels. This article explores the latest developments in solar, wind, and hydroelectric power technologies.'
        ],
        [
            'block_type' => 'image',
            'image_url' => '/images/solar-farm.jpg',
            'image_alt' => 'Large solar panel farm',
            'image_caption' => 'Solar farms are becoming more efficient and affordable'
        ],
        [
            'block_type' => 'heading',
            'content' => 'Solar Power Innovations'
        ],
        [
            'block_type' => 'paragraph',
            'content' => 'Recent advancements in photovoltaic technology have increased solar panel efficiency by over 40%. New materials like perovskite are making panels cheaper to produce while maintaining high energy conversion rates.'
        ],
        [
            'block_type' => 'list',
            'content' => 'Thin-film solar cells, Bifacial solar panels, Solar tracking systems, Building-integrated photovoltaics'
        ],
        [
            'block_type' => 'quote',
            'content' => 'The sun does not shine for a few trees and flowers, but for the wide world\'s joy.',
            'image_caption' => 'Henry Ward Beecher'
        ],
        [
            'block_type' => 'video',
            'content' => '/videos/wind-turbine.mp4',
            'image_caption' => 'Offshore wind turbine installation process'
        ],
        [
            'block_type' => 'cta',
            'content' => 'Want to learn more about renewable energy solutions?',
            'additional_data' => [
                'cta_link' => '/contact',
                'cta_text' => 'Contact Our Experts'
            ]
        ],
        [
            'block_type' => 'faq',
            'content' => json_encode([
                [
                    'question' => 'How much does solar panel installation cost?',
                    'answer' => 'The average residential solar panel system costs between $15,000 and $25,000 after tax credits.'
                ],
                [
                    'question' => 'How long do solar panels last?',
                    'answer' => 'Most solar panels come with 25-year warranties and typically last 30-35 years.'
                ]
            ])
        ],
        [
            'block_type' => 'divider'
        ],
        [
            'block_type' => 'paragraph',
            'content' => 'The renewable energy sector continues to grow at an unprecedented rate, offering both environmental benefits and economic opportunities for communities worldwide.'
        ]
    ]
];
?> -->
<!-- Article Template with Tailwind CSS -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-8"><?= htmlspecialchars($article['title']) ?></h1>

    <div class="space-y-8">
        <?php foreach ($article['blocks'] as $block): ?>
            <?php
            switch ($block['block_type']) {
                case 'paragraph':
                    echo '<div class="text-gray-700 leading-relaxed">'
                        . htmlspecialchars($block['content']) .
                        '</div>';
                    break;

                case 'heading':
                    echo '<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">'
                        . htmlspecialchars($block['content']) .
                        '</h2>';
                    break;

                case 'image':
                    ?>
                    <div class="my-6">
                        <img 
                            src="<?= htmlspecialchars($block['image_url']) ?>" 
                            alt="<?= htmlspecialchars($block['image_alt']) ?>" 
                            class="w-full rounded-lg shadow-md"
                        >
                        <p class="mt-2 text-sm text-gray-500 text-center">
                            <?= htmlspecialchars($block['image_caption']) ?>
                        </p>
                    </div>
                    <?php
                    break;

                case 'video':
                    ?>
                    <div class="my-6">
                        <video controls class="w-full rounded-lg shadow-md">
                            <source src="<?= htmlspecialchars($block['content']) ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p class="mt-2 text-sm text-gray-500 text-center">
                            <?= htmlspecialchars($block['image_caption']) ?>
                        </p>
                    </div>
                    <?php
                    break;

                case 'list':
                    ?>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700 my-4">
                        <?php foreach (explode(',', $block['content']) as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                    break;

                case 'quote':
                    ?>
                    <div class="my-8 p-6 bg-gray-50 border-l-4 border-blue-500 rounded">
                        <blockquote class="italic text-gray-700 text-lg">
                            "<?= htmlspecialchars($block['content']) ?>"
                        </blockquote>
                        <p class="mt-2 text-gray-600 font-medium">
                            — <?= htmlspecialchars($block['image_caption']) ?>
                        </p>
                    </div>
                    <?php
                    break;

                case 'cta':
                    ?>
                    <div class="my-8 p-6 bg-blue-50 rounded-lg text-center">
                        <p class="text-gray-700 mb-4 text-lg">
                            <?= htmlspecialchars($block['content']) ?>
                        </p>
                        <a 
                            href="<?= htmlspecialchars($block['additional_data']['cta_link']) ?>" 
                            class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                        >
                            <?= htmlspecialchars($block['additional_data']['cta_text']) ?>
                        </a>
                    </div>
                    <?php
                    break;

                case 'faq':
                    ?>
                    <div class="my-8 space-y-4">
                        <?php foreach (json_decode($block['content'], true) as $faq): ?>
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="font-bold text-gray-800 text-lg">
                                    <?= htmlspecialchars($faq['question']) ?>
                                </h3>
                                <p class="mt-1 text-gray-700">
                                    <?= htmlspecialchars($faq['answer']) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    break;

                case 'divider':
                    echo '<hr class="my-8 border-gray-200">';
                    break;
            }
            ?>
        <?php endforeach; ?>
    </div>
</div>
------------------------------------------------------------------------------------
different blocks
------------------------------------------------------------------------------------

<div class="article-block paragraph-block">
    <p class="content">
        <!-- Placeholder for dynamic paragraph content -->
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.
    </p>
</div>



<div class="article-block heading-block">
    <h2 class="content">
        <!-- Placeholder for dynamic heading content -->
        Section Heading
    </h2>
</div>


<div class="article-block image-block">
    <img src="<!-- Placeholder for image URL -->" alt="<!-- Placeholder for image alt text -->" class="content">
    <p class="caption">
        <!-- Placeholder for image caption -->
        Caption for the image goes here.
    </p>
</div>



<div class="article-block video-block">
    <video controls class="content">
        <source src="<!-- Placeholder for video URL -->" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <p class="caption">
        <!-- Placeholder for video caption -->
        Video caption goes here.
    </p>
</div>



<div class="article-block audio-block">
    <audio controls class="content">
        <source src="<!-- Placeholder for audio URL -->" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <p class="caption">
        <!-- Placeholder for audio caption -->
        Audio caption goes here.
    </p>
</div>



<div class="article-block list-block">
    <ul class="content">
        <li><!-- Placeholder for list item -->Item 1</li>
        <li><!-- Placeholder for list item -->Item 2</li>
        <li><!-- Placeholder for list item -->Item 3</li>
    </ul>
</div>



<div class="article-block quote-block">
    <blockquote class="content">
        <!-- Placeholder for quote content -->
        "This is a sample quote."
    </blockquote>
    <p class="attribution">
        <!-- Placeholder for quote attribution -->
        - Author Name
    </p>
</div>



<div class="article-block embed-block">
    <div class="content">
        <!-- Placeholder for embed content (e.g., embedded video, map, etc.) -->
        <iframe src="<!-- Placeholder for embed URL -->" width="560" height="315"></iframe>
    </div>
</div>




<div class="article-block cta-block">
    <div class="content">
        <p>
            <!-- Placeholder for CTA text -->
            Sign up now for more exclusive content!
        </p>
        <a href="<!-- Placeholder for CTA link -->" class="btn btn-primary">Sign Up</a>
    </div>
</div>




<div class="article-block faq-block">
    <div class="content">
        <h3>FAQ Question 1</h3>
        <p><!-- Placeholder for FAQ answer -->This is the answer to FAQ question 1.</p>

        <h3>FAQ Question 2</h3>
        <p><!-- Placeholder for FAQ answer -->This is the answer to FAQ question 2.</p>
    </div>
</div>




<div class="article-block divider-block">
    <hr class="content">
</div>
