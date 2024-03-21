<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318113524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dividend_payment (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, record_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', amount JSON NOT NULL, INDEX IDX_1678C3E3DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, value JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_dividend_payment (portfolio_id INT NOT NULL, dividend_id INT NOT NULL, INDEX IDX_EEB1E02EB96B5643 (portfolio_id), INDEX IDX_EEB1E02EC6E33966 (dividend_id), PRIMARY KEY(portfolio_id, dividend_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_holding (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, stock_id INT DEFAULT NULL, number_of_shares NUMERIC(4, 0) NOT NULL COMMENT \'(DC2Type:number_of_shares_type)\', INDEX IDX_D0AF7D8B96B5643 (portfolio_id), UNIQUE INDEX UNIQ_D0AF7D8DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_transaction (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, holding_id INT DEFAULT NULL, stock_ticker VARCHAR(5) NOT NULL, number_of_shares NUMERIC(4, 0) NOT NULL COMMENT \'(DC2Type:number_of_shares_type)\', value JSON NOT NULL, transaction_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', transaction_type ENUM(\'BUY\', \'SELL\', \'CLOSE_POSITION\') NOT NULL COMMENT \'(DC2Type:transaction_type)\', INDEX IDX_CC0E3305B96B5643 (portfolio_id), INDEX IDX_CC0E33056CD5FBA3 (holding_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, ticker VARCHAR(5) NOT NULL, market_symbol ENUM(\'NYSE\', \'NASDAQ\') NOT NULL COMMENT \'(DC2Type:market_symbol)\', currency VARCHAR(3) NOT NULL, INDEX ticker_idx (ticker), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dividend_payment ADD CONSTRAINT FK_1678C3E3DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_payment ADD CONSTRAINT FK_EEB1E02EB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_payment ADD CONSTRAINT FK_EEB1E02EC6E33966 FOREIGN KEY (dividend_id) REFERENCES dividend_payment (id)');
        $this->addSql('ALTER TABLE portfolio_holding ADD CONSTRAINT FK_D0AF7D8B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_holding ADD CONSTRAINT FK_D0AF7D8DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE portfolio_transaction ADD CONSTRAINT FK_CC0E3305B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_transaction ADD CONSTRAINT FK_CC0E33056CD5FBA3 FOREIGN KEY (holding_id) REFERENCES portfolio_holding (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dividend_payment DROP FOREIGN KEY FK_1678C3E3DCD6110');
        $this->addSql('ALTER TABLE portfolio_dividend_payment DROP FOREIGN KEY FK_EEB1E02EB96B5643');
        $this->addSql('ALTER TABLE portfolio_dividend_payment DROP FOREIGN KEY FK_EEB1E02EC6E33966');
        $this->addSql('ALTER TABLE portfolio_holding DROP FOREIGN KEY FK_D0AF7D8B96B5643');
        $this->addSql('ALTER TABLE portfolio_holding DROP FOREIGN KEY FK_D0AF7D8DCD6110');
        $this->addSql('ALTER TABLE portfolio_transaction DROP FOREIGN KEY FK_CC0E3305B96B5643');
        $this->addSql('ALTER TABLE portfolio_transaction DROP FOREIGN KEY FK_CC0E33056CD5FBA3');
        $this->addSql('DROP TABLE dividend_payment');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE portfolio_dividend_payment');
        $this->addSql('DROP TABLE portfolio_holding');
        $this->addSql('DROP TABLE portfolio_transaction');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
