<?php header("Content-type: text/xml");?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($items as $item): ?>
        <url>
            <loc><?= $item['link']; ?></loc>
            <lastmod><?= date(DATE_W3C, time()); ?></lastmod>
            <changefreq><?= $item['changeFrequency']; ?></changefreq>
            <priority><?= $item['priority']; ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>