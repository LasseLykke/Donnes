CREATE TABLE `ADJ rammer`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ordrenummer` INT NOT NULL,
    `kunde_id` INT NOT NULL,
    `dato` DATE NOT NULL,
    `rammeprofil` INT NOT NULL,
    `rammestørrelse` VARCHAR(255) NOT NULL,
    `glastype` VARCHAR(255) NOT NULL,
    `passepartout` VARCHAR(255) NOT NULL,
    `passepartoutFarve` INT NOT NULL,
    `hulmål` VARCHAR(255) NOT NULL,
    `antal` INT NOT NULL,
    `montering` VARCHAR(255) NOT NULL,
    `billedetype` VARCHAR(255) NOT NULL,
    `pris` DOUBLE(8, 2) NOT NULL,
    `bestilt` VARCHAR(255) NOT NULL,
    `betalt` VARCHAR(255) NOT NULL,
    `ekspedient` VARCHAR(255) NOT NULL
);
CREATE TABLE `Kunde`(
    `kunde_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kunde_navn` VARCHAR(255) NOT NULL,
    `kunde_telefon` VARCHAR(255) NOT NULL
);
CREATE TABLE `Kunde_ordre`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ordrenummer` INT NOT NULL,
    `kunde_id` INT NOT NULL,
    `leverandør` VARCHAR(255) NOT NULL,
    `produkt` VARCHAR(255) NOT NULL,
    `pris` VARCHAR(255) NOT NULL,
    `ekspedient` VARCHAR(255) NOT NULL
);
CREATE TABLE `users`(
    `users_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `pwd` VARCHAR(255) NOT NULL
);
CREATE TABLE `Leverandør`(
    `leverandør_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ringfoto` VARCHAR(255) NOT NULL,
    `europafoto` VARCHAR(255) NOT NULL,
    `focusnordic` VARCHAR(255) NOT NULL,
    `hhc` VARCHAR(255) NOT NULL,
    `tura` VARCHAR(255) NOT NULL,
    `guntex` VARCHAR(255) NOT NULL,
    `mmd` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `ADJ rammer` ADD CONSTRAINT `adj rammer_kunde_id_foreign` FOREIGN KEY(`kunde_id`) REFERENCES `Kunde`(`kunde_id`);
ALTER TABLE
    `ADJ rammer` ADD CONSTRAINT `adj rammer_ekspedient_foreign` FOREIGN KEY(`ekspedient`) REFERENCES `users`(`users_id`);
ALTER TABLE
    `Kunde_ordre` ADD CONSTRAINT `kunde_ordre_ekspedient_foreign` FOREIGN KEY(`ekspedient`) REFERENCES `users`(`users_id`);
ALTER TABLE
    `Kunde_ordre` ADD CONSTRAINT `kunde_ordre_kunde_id_foreign` FOREIGN KEY(`kunde_id`) REFERENCES `Kunde`(`kunde_id`);
ALTER TABLE
    `Kunde_ordre` ADD CONSTRAINT `kunde_ordre_leverandør_foreign` FOREIGN KEY(`leverandør`) REFERENCES `Leverandør`(`leverandør_id`);