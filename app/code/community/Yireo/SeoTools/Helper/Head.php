<?php
/**
 * Yireo SeoTools for Magento 
 *
 * @package     Yireo_SeoTools
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2015 Yireo (https://www.yireo.com/)
 * @license     Open Source License
 */

/**
 * SeoTools helper to modify the HTML-head
 */
class Yireo_SeoTools_Help_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Method to get the document title
     *
     * @return string
     */
    public function getTitle()
    {
        // Get the head-block and fetch the title
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            return $headBlock->getTitle();
        }
    }

    /**
     * Method to set the document title
     *
     * @param string $title New document title to set
     * @return bool
     */
    public function setTitle($title = null)
    {
        // Get the head-block and set the title
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->setTitle($title);
            return true;
        }
        return false;
    }

    /**
     * Method to get the document keywords
     *
     * @return array
     */
    public function getKeywords()
    {
        // Get the head-block and get the keywords
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $keywords = $headBlock->getKeywords();

            // Convert the keyword-string into a clean array
            $keywords = implode(',', $keywords);
            foreach($keywords as $keywordIndex => $keyword) {
                $keywords[$keywordIndex] = trim($keyword);
            }

            return $keywords;
        }
        return array();
    }

    /**
     * Method to set the document keywords
     *
     * @param $keywords array List of keywords to insert
     * @param $prepend false Append or prepend the keywords
     * @param $overwrite false Overwrite current list of keywords
     * @return bool
     */
    public function setKeywords($keywords = array(), $prepend = false, $overwrite = false)
    {
        // Get the head-bloc
        $headBlock = $this->getLayout()->getBlock('head');
        if (empty($headBlock)) {
            return false;
        }

        // Append or prepend the keywords
        if($overwrite == false) {
            $currentKeywords = $this->getKeywords();
            if($prepend == true) {
                $keywords = array_merge($keywords, $currentKeywords);
            } else {
                $keywords = array_merge($currentKeywords, $keywords);
            }
        }

        // Correct the array
        if(is_array($keywords)) {
            $keywords = array_unique($keywords);
            $keywords = implode(', ', $keywords);
        }

        // Actually set the keywords as a string 
        $headBlock->setKeywords($keywords);
        return true;
    }

    /**
     * Method to get the current store name
     *
     * @return string
     */
    public function getStoreName()
    {
        return Mage::getStoreConfig('system/store/name');
    }

    /**
     * Method to get the seperator
     *
     * @return string
     */
    public function getSeperator()
    {
        return ' '.Mage::getStoreConfig('catalog/seo/title_separator').' ';
    }

    /**
     * Method to get the current category-title
     *
     * @return string
     */
    public function getCategoryTitle()
    {
        $category = Mage::registry('current_category');
        if(!empty($category)) {
            return $category->getName();
        }
        return null;
    }

    /**
     * Method to get the current product-title
     *
     * @return string
     */
    public function getProductTitle()
    {
        $product = Mage::registry('current_product');
        if(!empty($product)) {
            return $product->getName();
        }
        return null;
    }
}
