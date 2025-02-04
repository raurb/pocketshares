<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241026220404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exchange_rate (id INT AUTO_INCREMENT NOT NULL, currency_from VARCHAR(3) NOT NULL, currency_to VARCHAR(3) NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', rate NUMERIC(9, 5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, value JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_dividend_income_tax (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, system_dividend_id INT DEFAULT NULL, exchange_rate_id INT DEFAULT NULL, stock_ticker VARCHAR(5) NOT NULL, dividend_gross_amount JSON NOT NULL, income_tax_currency VARCHAR(255) NOT NULL, withholding_tax_amount JSON NOT NULL, withholding_tax_rate NUMERIC(9, 5) NOT NULL, income_tax_rate NUMERIC(9, 5) NOT NULL, dividend_amount_in_target_currency_gross JSON NOT NULL, dividend_withholding_tax_in_target_currency JSON NOT NULL, tax_to_pay_in_target_currency JSON NOT NULL, tax_left_to_pay_in_target_currency JSON NOT NULL, dividend_amount_in_target_currency_net JSON NOT NULL, INDEX IDX_CC1C63FEB96B5643 (portfolio_id), INDEX IDX_CC1C63FE9953627E (system_dividend_id), INDEX IDX_CC1C63FEFB53491E (exchange_rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_dividend_payment (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, dividend_payment_id INT NOT NULL, number_of_shares NUMERIC(17, 6) NOT NULL COMMENT \'(DC2Type:number_of_shares_type)\', INDEX IDX_EEB1E02EB96B5643 (portfolio_id), INDEX IDX_EEB1E02E73ECD65C (dividend_payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_holding (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, stock_id INT DEFAULT NULL, number_of_shares NUMERIC(17, 6) NOT NULL COMMENT \'(DC2Type:number_of_shares_type)\', INDEX IDX_D0AF7D8B96B5643 (portfolio_id), INDEX IDX_D0AF7D8DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_transaction (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, holding_id INT DEFAULT NULL, stock_ticker VARCHAR(5) NOT NULL, number_of_shares NUMERIC(17, 6) NOT NULL COMMENT \'(DC2Type:number_of_shares_type)\', price_per_share JSON NOT NULL, transaction_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', transaction_type ENUM(\'BUY\', \'SELL\', \'CLOSE_POSITION\') NOT NULL COMMENT \'(DC2Type:transaction_type)\', INDEX IDX_CC0E3305B96B5643 (portfolio_id), INDEX IDX_CC0E33056CD5FBA3 (holding_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, ticker VARCHAR(5) NOT NULL, market_symbol ENUM(\'NYSE\', \'NASDAQ\', \'BATS\') NOT NULL COMMENT \'(DC2Type:market_symbol)\', currency VARCHAR(3) NOT NULL, INDEX ticker_idx (ticker), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system_dividend_payment (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, payout_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', amount JSON NOT NULL, INDEX IDX_A2992888DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax ADD CONSTRAINT FK_CC1C63FEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax ADD CONSTRAINT FK_CC1C63FE9953627E FOREIGN KEY (system_dividend_id) REFERENCES system_dividend_payment (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax ADD CONSTRAINT FK_CC1C63FEFB53491E FOREIGN KEY (exchange_rate_id) REFERENCES exchange_rate (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_payment ADD CONSTRAINT FK_EEB1E02EB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_dividend_payment ADD CONSTRAINT FK_EEB1E02E73ECD65C FOREIGN KEY (dividend_payment_id) REFERENCES system_dividend_payment (id)');
        $this->addSql('ALTER TABLE portfolio_holding ADD CONSTRAINT FK_D0AF7D8B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_holding ADD CONSTRAINT FK_D0AF7D8DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE portfolio_transaction ADD CONSTRAINT FK_CC0E3305B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_transaction ADD CONSTRAINT FK_CC0E33056CD5FBA3 FOREIGN KEY (holding_id) REFERENCES portfolio_holding (id)');
        $this->addSql('ALTER TABLE system_dividend_payment ADD CONSTRAINT FK_A2992888DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax DROP FOREIGN KEY FK_CC1C63FEB96B5643');
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax DROP FOREIGN KEY FK_CC1C63FE9953627E');
        $this->addSql('ALTER TABLE portfolio_dividend_income_tax DROP FOREIGN KEY FK_CC1C63FEFB53491E');
        $this->addSql('ALTER TABLE portfolio_dividend_payment DROP FOREIGN KEY FK_EEB1E02EB96B5643');
        $this->addSql('ALTER TABLE portfolio_dividend_payment DROP FOREIGN KEY FK_EEB1E02E73ECD65C');
        $this->addSql('ALTER TABLE portfolio_holding DROP FOREIGN KEY FK_D0AF7D8B96B5643');
        $this->addSql('ALTER TABLE portfolio_holding DROP FOREIGN KEY FK_D0AF7D8DCD6110');
        $this->addSql('ALTER TABLE portfolio_transaction DROP FOREIGN KEY FK_CC0E3305B96B5643');
        $this->addSql('ALTER TABLE portfolio_transaction DROP FOREIGN KEY FK_CC0E33056CD5FBA3');
        $this->addSql('ALTER TABLE system_dividend_payment DROP FOREIGN KEY FK_A2992888DCD6110');
        $this->addSql('DROP TABLE exchange_rate');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE portfolio_dividend_income_tax');
        $this->addSql('DROP TABLE portfolio_dividend_payment');
        $this->addSql('DROP TABLE portfolio_holding');
        $this->addSql('DROP TABLE portfolio_transaction');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE system_dividend_payment');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
