<?php
require_once 'Databases.php';

$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'Project';

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $insertAnimalCategories = "INSERT IGNORE INTO animalcategories (category_name) VALUES
    ('Mammals'),
    ('Birds'),
    ('Reptiles'),
    ('Amphibians'),
    ('Fish')";
    $pdo->exec($insertAnimalCategories);

    $insertSpecies = "INSERT INTO species (category_id, common_name, scientific_name, conservation_status, diet, behaviour, image)
VALUES
    -- Mammals
    (1, 'Capybara', 'Hydrochoerus hydrochaeris', 'Least Concern', 'Herbivorous', 'Capybaras are social animals, usually found in groups of 10-20 individuals. They are semi-aquatic, often found near water bodies where they can swim and escape predators.', 'https://i.imgur.com/JxtP8uE.png'),
    (1, 'Hyrax', 'Procavia capensis', 'Least Concern', 'Herbivorous', 'Hyraxes are small, social mammals that live in rocky terrain. They are diurnal (active during the day) and communicate using various vocalizations.', 'https://i.imgur.com/rWEiDLw.png'),
    (1, 'African Elephant', 'Loxodonta africana', 'Vulnerable', 'Herbivorous', 'African elephants are highly social and live in matriarchal herds led by an older female. They have complex communication skills, including infrasound that travels long distances.', 'https://i.imgur.com/56ORra3.png'),
    (1, 'Cheetah', 'Acinonyx jubatus', 'Vulnerable', 'Carnivorous', 'Cheetahs are solitary hunters but may form small groups, especially mothers with cubs. They are known for their incredible speed and agility, capable of short bursts up to 60-70 mph.', 'https://i.imgur.com/DedTOu8.png'),
    (1, 'African Lion', 'Panthera leo', 'Vulnerable', 'Carnivorous', 'African lions are social cats that live in prides led by a dominant male. They are apex predators and exhibit cooperative hunting behaviors, often working together to bring down prey.', 'https://i.imgur.com/KN5EXeL.jpeg'),
    (1, 'Bengal Tiger', 'Panthera tigris tigris', 'Endangered', 'Carnivorous', 'Bengal tigers are solitary animals, except during mating or when females are with cubs. They are powerful hunters and are known for their striped coat pattern.', 'https://i.imgur.com/Nxd7epJ.png'),
    (1, 'Snow Leopard', 'Panthera uncia', 'Vulnerable', 'Carnivorous', 'Snow leopards are solitary and elusive cats found in mountainous regions of Central and South Asia. They are well adapted to cold environments and are known for their agility and stealth in hunting.', 'https://i.imgur.com/0qE1tkd.png'),
    (1, 'Sand Cat', 'Felis margarita', 'Least Concern', 'Carnivorous', 'Sand cats are small, solitary cats adapted to desert environments. They are nocturnal and have large ears that help them detect prey and stay cool in hot climates.', 'https://i.imgur.com/WVHDDxD.png'),
    (1, 'Binturong', 'Arctictis binturong', 'Vulnerable', 'Omnivorous', 'Binturongs are arboreal (tree-dwelling) and nocturnal animals found in Southeast Asia. They are known for their prehensile tail, which helps them climb and maneuver in trees.', 'https://i.imgur.com/21zwqZ3.png'),
    (1, 'Zebra', 'Equus quagga', 'Near Threatened', 'Herbivorous', 'Zebras are social animals known for their distinctive black-and-white striped coats. They live in herds and are commonly found in savannas and grasslands in Africa. Zebras communicate through vocalizations, body language, and facial expressions.', 'https://i.imgur.com/sOdsraN.jpeg'),

    -- Birds
    (2, 'Bald Eagle', 'Haliaeetus leucocephalus', 'Least Concern', 'Carnivorous', 'Bald eagles are majestic birds of prey found in North America. They are known for their white head and tail feathers.', 'https://i.imgur.com/BIvuW69.png'),
    (2, 'Penguin', 'Spheniscidae', 'Varies by species', 'Piscivorous', 'Penguins are flightless birds adapted to aquatic life. They are excellent swimmers and can be found in various regions from Antarctica to the Galápagos Islands.', 'https://i.imgur.com/RDIjmuj.png'),
    -- Reptiles
    (3, 'Green Anaconda', 'Eunectes murinus', 'Least Concern', 'Carnivorous', 'Green anacondas are massive snakes found in South America. They are aquatic and known for their ability to ambush and constrict large prey.', 'https://i.imgur.com/ddJbmyh.jpeg'),
    (3, 'Galápagos Tortoise', 'Chelonoidis nigra', 'Vulnerable', 'Herbivorous', 'Galápagos tortoises are giant tortoises found on the Galápagos Islands. They are long-lived and primarily herbivorous.', 'https://i.imgur.com/BZGCT8s.png'),
    -- Amphibians
    (4, 'Axolotl', 'Ambystoma mexicanum', 'Critically Endangered', 'Carnivorous', 'Axolotls are unique salamanders native to Mexico. They are known for their regenerative abilities and neoteny, retaining larval features throughout their lives.', 'https://i.imgur.com/5kThq4Z.png'),
    (4, 'Red-eyed Tree Frog', 'Agalychnis callidryas', 'Least Concern', 'Insectivorous', 'Red-eyed tree frogs are colorful amphibians found in Central America. They are arboreal and primarily feed on insects.', 'https://i.imgur.com/aHxir0L.png'),
    (4, 'Poison Dart Frog', 'Dendrobatidae', 'Varies by species', 'Insectivorous', 'Poison dart frogs are small but brightly colored frogs found in Central and South America. They secrete toxins through their skin for defense against predators.', 'https://i.imgur.com/OUuE5Vx.png');";
    $pdo->exec($insertSpecies);


    $insertAnimals = "INSERT INTO animals (animal_name, species_id, habitat_id, date_of_birth, description, image) VALUES
    -- Mammals
    ('Alpha', 1, 1, '2019-05-15', 'Capybara Alpha is a friendly herbivorous mammal often found near rivers.', 'https://i.imgur.com/Xg5aNCX.png'),
    ('Beta', 1, 1, '2020-01-22', 'Capybara Beta enjoys swimming and grazing in open grasslands.', 'https://i.imgur.com/2TlmN3O.png'),
    ('Charlie', 1, 1, '2018-07-10', 'Capybara Charlie likes to explore new habitats and is curious about everything.', 'https://i.imgur.com/NRLN8vD.png'),
    ('Delta', 1, 1, '2017-11-28', 'Capybara Delta is known for its playful nature and can often be seen splashing around in water.', 'https://i.imgur.com/CgyIiBq.png'),
    ('Echo', 1, 1, '2019-09-05', 'Capybara Echo is a social creature that enjoys grooming sessions with its group members.', 'https://i.imgur.com/RRndXnV.png'),
    ('Foxtrot', 1, 1, '2018-03-12', 'Capybara Foxtrot is a skilled swimmer and loves diving into ponds to find aquatic plants.', 'https://i.imgur.com/TZ5OEG6.png'),
    ('Golf', 1, 1, '2017-06-30', 'Capybara Golf is an adventurous explorer, often venturing into new areas to forage for food.', 'https://i.imgur.com/8vpHiXk.png'),
    ('Hotel', 1, 1, '2016-10-15', 'Capybara Hotel is a gentle giant that enjoys basking in the sun during lazy afternoons.', 'https://i.imgur.com/wj0Whxl.png'),
    
    ('Adam', 2, 2, '2018-11-10', 'Hyrax Adam lives in rocky terrains and loves basking in the sun during the day.', 'https://i.imgur.com/orSK40s.png'),
    ('Eve', 2, 2, '2017-08-03', 'Hyrax Eve is a social herbivore that communicates through various vocalizations.', 'https://i.imgur.com/TODPwN0.png'),
    ('Felix', 2, 2, '2019-02-18', 'Hyrax Felix is adventurous and enjoys climbing rocky cliffs to get a better view of its surroundings.', 'https://i.imgur.com/seZd1XW.png'),
    ('Greta', 2, 2, '2016-06-25', 'Hyrax Greta is a cautious creature that prefers the safety of shaded areas during the hottest parts of the day.', 'https://i.imgur.com/KWPPM3N.png'),
    
    ('Ellie', 3, 3, '2015-03-20', 'Ellie the African Elephant is a gentle giant known for its intelligence and strong social bonds within the herd.', 'https://i.imgur.com/knlfLfc.jpeg'),
    ('Dumbo', 3, 3, '2016-07-14', 'Dumbo the African Elephant has a distinctive set of tusks and loves bathing in mud to keep cool.', 'https://i.imgur.com/JykX07i.png'),
    ('Szymon', 3, 3, '2016-07-14', 'Szymon the African Elephant is known for its playful nature and enjoys interacting with other members of the herd.', 'https://i.imgur.com/An9are8.jpeg'),

    ('Lightning', 4, 4, '2019-09-28', 'Lightning the Cheetah is a swift carnivore known for its impressive hunting prowess and sleek build.', 'https://i.imgur.com/tFErFUo.png'),
    ('Spots', 4, 4, '2020-04-12', 'Spots the Cheetah enjoys sprinting across the savannah and resting under shady trees.', 'https://i.imgur.com/g3sbAJm.png'),
    
    ('Leo', 5, 5, '2017-12-05', 'Leo the African Lion is a majestic carnivore known for its loud roar and regal mane.', 'https://i.imgur.com/lGpbBSg.png'),
    ('Nala', 5, 5, '2024-06-19', 'Nala the African Lion is part of a pride led by a dominant male and is skilled in cooperative hunting.', 'https://i.imgur.com/sQ9JCvW.png'),
    
    ('Tigger', 6, 6, '2016-10-30', 'Tigger the Bengal Tiger is a solitary predator with striking orange and black stripes.', 'https://i.imgur.com/Mv3C5mL.jpeg'),
    ('Shere Khan', 6, 6, '2015-04-17', 'Shere Khan the Bengal Tiger roams the dense forests stealthily, hunting deer and wild boars.', 'https://i.imgur.com/R7CGpeg.png'),
    
    ('Blizzard', 7, 7, '2018-02-14', 'Blizzard the Snow Leopard is an elusive predator of the mountain ranges, adapted to cold environments and known for its agility and stealth in hunting.', 'https://i.imgur.com/RpT10fp.png'),
    ('Frost', 7, 7, '2019-10-01', 'Frost the Snow Leopard prowls the snowy peaks with unmatched grace, blending seamlessly into its environment.', 'https://i.imgur.com/9W8ggBE.png'),
    
    ('Zuzia', 10, 15, '2020-03-14', 'Zuzia the Zebra is known for her striking black-and-white stripes, social nature, and love for grazing on the savannah.', 'https://i.imgur.com/hycX8bT.png'),
    
    -- Birds
    ('Freedom', 11, 8, '2017-05-25', 'Freedom the Bald Eagle soars through the skies of North America, symbolizing strength and independence.', 'https://i.imgur.com/9zdVf98.png'),
    ('Liberty', 11, 8, '2018-09-12', 'Liberty the Bald Eagle is a skilled hunter with keen eyesight, often seen near bodies of water.', 'https://i.imgur.com/HkkN2Lw.png'),
    
    ('Chilly', 12, 9, '2016-12-08', 'Chilly the Penguin waddles gracefully across icy terrain, expertly navigating the waters of the Antarctic.', 'https://i.imgur.com/DHwqgPf.png'),
    ('Flipper', 12, 9, '2015-07-03', 'Flipper the Penguin loves to dive deep into the ocean, catching fish with swift movements.', 'https://i.imgur.com/DHwqgPf.png'),
    
    -- Reptiles
    ('Ana', 13, 10, '2017-04-20', 'Ana the Green Anaconda is a massive serpent lurking in the rivers of South America, known for its ambush hunting technique.', 'https://i.imgur.com/nEe3maA.png'),
    ('Conda', 13, 10, '2018-11-29', 'Conda the Green Anaconda coils around its prey with incredible strength, dominating its aquatic domain.', 'https://i.imgur.com/5xEXyS9.png'),
    
    ('Darwin', 14, 11, '2016-08-15', 'Darwin the Galápagos Tortoise is a living relic of evolution, wandering the volcanic islands with deliberate steps.', 'https://i.imgur.com/Kq7RRuO.png'),
    ('Shellby', 14, 11, '2015-03-07', 'Shellby the Galápagos Tortoise grazes leisurely on vegetation, its slow pace reflecting the calmness of island life.', 'https://i.imgur.com/gyi1hmu.jpeg'),
    
    -- Amphibians
    ('Axle', 15, 12, '2019-01-12', 'Axle the Axolotl is a unique amphibian that regenerates its limbs with astonishing speed, thriving in aquatic habitats.', 'https://i.imgur.com/NZTw6U0.png'),
    ('Nix', 15, 12, '2020-04-30', 'Nix the Axolotl remains youthful and vibrant, its neotenic features captivating observers with every graceful movement.', 'https://i.imgur.com/vZvyWQZ.png'),
    
    ('Rio', 16, 13, '2018-06-18', 'Rio the Red-eyed Tree Frog leaps through the rainforest canopy, its vibrant colors warning predators of its toxic skin.', 'https://i.imgur.com/yIFz7fL.png'),
    ('Ember', 16, 13, '2017-12-03', 'Ember the Red-eyed Tree Frog hides among lush foliage, its crimson eyes watching for insect prey.', 'https://i.imgur.com/WyxE6G2.jpeg'),
    
    ('Venom', 17, 14, '2016-03-22', 'Venom the Poison Dart Frog moves with caution, its vivid colors serving as a deadly warning to those who dare to touch.', 'https://i.imgur.com/wehlLsT.png'),
    ('Dart', 17, 14, '2015-08-11', 'Dart the Poison Dart Frog navigates the forest floor with agility, relying on camouflage and poison for defense.', 'https://i.imgur.com/WVfBAJU.png');";
    $pdo->exec($insertAnimals);

    $password1 = password_hash("password123", PASSWORD_DEFAULT);
    $insertZookeepers = "INSERT IGNORE INTO zookeepers (zookeeper_first_name, zookeeper_last_name, zookeeper_email, zookeeper_phone, zookeeper_password) VALUES
        ('John', 'Doe', 'john.doe@example.com', '555-1234', '$password1'),
        ('Jane', 'Smith', 'jane.smith@example.com', '555-5678', '$password1'),
        ('Alice', 'Johnson', 'alice.johnson@example.com', '555-8765', '$password1'),
        ('Bob', 'Brown', 'bob.brown@example.com', '555-4321', '$password1'),
        ('Charlie', 'Davis', 'charlie.davis@example.com', '555-9101', '$password1');";
    $pdo->exec($insertZookeepers);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
