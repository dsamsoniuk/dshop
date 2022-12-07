<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207090845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F5299398EBF23851, ADD INDEX IDX_F5299398EBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F52993984C3A3BB, ADD INDEX IDX_F52993984C3A3BB (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F5299398EBF23851, ADD UNIQUE INDEX UNIQ_F5299398EBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F52993984C3A3BB, ADD UNIQUE INDEX UNIQ_F52993984C3A3BB (payment_id)');
    }
}
