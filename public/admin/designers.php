<?php
// Mock data for designers
$designerData = [
    ['designer_id' => '#QA153', 'name' => 'John Doe', 'registered_on' => 'May 15, 2021', 'tele_num' => '0114879568', 'email' => 'john.doe@mymail.com'],
    ['designer_id' => '#WE117', 'name' => 'Mike WIllis', 'registered_on' => 'February 26, 2021', 'tele_num' => '0119652354', 'email' => 'mikee.willis@wowmail.com'],
    ['designer_id' => '#ZA193', 'name' => 'Amanda Christina', 'registered_on' => 'August 5, 2020', 'tele_num' => '0119548562', 'email' => 'mikee.willis@wowmail.com'],
    ['designer_id' => '#KQ131', 'name' => 'George William', 'registered_on' => 'December 31, 2021', 'tele_num' => '0112659480', 'email' => 'amandachrist@omail.gov']
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
        <link rel="stylesheet" href="./styles/designers.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?> 
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="designers-display-box">
                    <div style="display: flex;
                                justify-content: space-between;
                                align-items: center;"
                         class="content-header">
                        <h2>Designers</h2>
                        <a href="./addDesigner.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Add Designer</a>
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
                                <tr onclick="window.location.href='designerDetails.php?designer_id=<?php echo urlencode($item['designer_id']); ?>'">
                                    <td><?php echo $item['designer_id']; ?></td>
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