<?php
// Mock data for designers
$designerData = [
    ['dsgn_id' => '#QA15932456', 'name' => 'John Doe', 'registered_on' => 'May 15, 2021', 'tele_num' => '0114879568', 'email' => 'john.doe@mymail.com'],
    ['dsgn_id' => '#WE15936541', 'name' => 'Mike WIllis', 'registered_on' => 'February 26, 2021', 'tele_num' => '0119652354', 'email' => 'mikee.willis@wowmail.com'],
    ['dsgn_id' => '#ZA15937153', 'name' => 'Amanda Christina', 'registered_on' => 'August 5, 2020', 'tele_num' => '0119548562', 'email' => 'mikee.willis@wowmail.com'],
    ['dsgn_id' => '#KQ15987512', 'name' => 'George William', 'registered_on' => 'December 31, 2021', 'tele_num' => '0112659480', 'email' => 'amandachrist@omail.gov']
];
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly Ltd</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="designers.css">
    </head>
    <body>
        <div class="page-content"> 
            <div class="main-content">
                <div class="orders-display-box">
                    <div style="display: flex;
                                justify-content: space-between;
                                align-items: center;">
                        <h2>Designers</h2>
                        <a href="/admin/add-designer.php">Add Designer</a>
                    </div>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Designer ID</th>
                                <th>Name</th>
                                <th>Registered on</th>
                                <th>Telephone no</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($designerData as $item): ?>
                                <tr>
                                    <td><?php echo $item['dsgn_id']; ?></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['registered_on']; ?></td>
                                    <td><?php echo $item['tele_num']; ?></td>
                                    <td><?php echo $item['email']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>