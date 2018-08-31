<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Nosto
 * @package   Nosto_Tagging
 * @author    Nosto Solutions Ltd <magento@nosto.com>
 * @copyright Copyright (c) 2013-2017 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper class for getting category related product data from Nosto
 *
 * @category Nosto
 * @package  Nosto_Tagging
 * @author   Nosto Solutions Ltd <magento@nosto.com>
 */
class Nosto_Tagging_Model_Service_Recommendation_Category
    extends Nosto_Tagging_Model_Service_Recommendation_Base
{
    /**
     * Returns an of product ids sorted by relevance
     *
     * @param Nosto_Object_Signup_Account $nostoAccount
     * @param $nostoCustomerId
     * @param $category
     * @param null $limit
     *
     * @return array
     */
    public function getSortedProductIds(
        Nosto_Object_Signup_Account $nostoAccount,
        $nostoCustomerId,
        $category,
        $limit = null
    )
    {
        if (!$limit) {
            $limit = 20;
        }

        $recoOperation = new Nosto_Operation_Recommendation_Category(
            $nostoAccount,
            $category,
            $nostoCustomerId,
            $limit
        );
        try {
            $response = $recoOperation->execute();
        } catch (\Exception $e) {
            Nosto_Tagging_Helper_Log::exception($e);
        }
        $productIds = array();

        // ToDo - wrap this into a nice result set in SDK
        foreach ($response->data->updateSession->recos->category_ids->primary as $item) {
            $productIds[] = $item->productId;
        }

        return $productIds;
    }
}