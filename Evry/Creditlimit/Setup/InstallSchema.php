<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
/**
* @codeCoverageIgnore
*/
class InstallSchema implements InstallSchemaInterface{
/**
* {@inheritdoc}
* @SuppressWarnings(PHPMD.ExcessiveMethodLength)
*/
public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){
$installer = $setup;
$installer->startSetup();

/**
* Creating table credit_limit
*/
$table = $installer->getConnection()->newTable(
$installer->getTable('credit_limit')
)->addColumn('enitity_id',\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],'Entity Id')
->addColumn('customer_id',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true],'Customer ID')
->addColumn('customer_email',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Email ID')
->addColumn('credit_limit',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Credit limit')
->addColumn('created_at',\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,null,['nullable' => false],'Created At')
->setComment('Evry India');
$installer->getConnection()->createTable($table);

$installer->getTable('credit_limit_report')
            )->addColumn('report_id',\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],'Report Id')
            ->addColumn('customer_id',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true],'Customer ID')
            ->addColumn('customer_email',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true],'Customer Email')
            ->addColumn('order_id',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true],'Order ID')
            ->addColumn('initial_credits',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Original Credits')
            ->addColumn('used_credits',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Used Credits')
            ->addColumn('available_credits',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Available Credits')
             ->addColumn('credit_usage',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Credit Usage (in %)')
            ->addColumn('created_at',\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,null,['nullable' => false],'Created At')
            ->setComment('Evry India');
            $installer->getConnection()->createTable($table);
			
$installer->getTable('credit_limit_wallet')
            )->addColumn('wallet_id',\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],'Wallet Id')
            ->addColumn('from_email',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true],'From Email')
            ->addColumn('to_email',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'To Email')
            ->addColumn('amount_sent',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Amount Sent')
            ->addColumn('amount_received',\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['nullable' => true,'default' => null],'Amount Received')
            ->addColumn('created_at',\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,null,['nullable' => false],'Created At')
            ->setComment('Evry India');
            $installer->getConnection()->createTable($table);

$installer->endSetup();





}
}