<?php
/**
* HDI 2Basket
* for Oxid eShop 4.5.0
*
*  This program is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  (at your option) any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*  @author HEINER DIRECT GmbH & Co.KG
*  @author Rafael Dabrowski
*  @link http://www-heiner-direct.com
*
*  @copyright HEINER DIRECT GmbH & Co. KG 2011
*  @license GPLv3
*
*/

class skutobasket extends skutobasket_parent
{
	public function tobasket()
	{
		$oConfig = oxRegistry::getConfig();
		$multiple = oxRegistry::getConfig()->getRequestParameter("multiple");
		if($multiple){
			$this->toBasketMultiple();
		}
		else{
			$this->toBasketSingle();
		}
			
	}
	
	public function getOxidFromArtnum($artnum)
	{
		$sOXID = null; 
			$rs = oxDb::getDB(true)->execute("select oxid from oxarticles where oxartnum = '".mysql_real_escape_string($artnum)."' AND oxactive='1' AND oxvarcount = 0 LIMIT 1");
			if ($rs != false && $rs->recordCount() > 0)
			{
				$sOXID=$rs->fields['oxid'];
			}
			else{
				$sOXID = null; 
			}
			
			return $sOXID;
	
	}
	public function toBasketSingle()
	{
		$oConfig = oxRegistry::getConfig();
		$fast= oxRegistry::getConfig()->getRequestParameter( 'fast');
		$am= oxRegistry::getConfig()->getRequestParameter( 'am');
		if ($fast)
		{
			$NoArticle=false;
			$artnum = oxRegistry::getConfig()->getRequestParameter("artnum");
			$rs = oxDb::getDB(true)->execute("select oxid from oxarticles where oxartnum = '".mysql_real_escape_string($artnum)."' AND oxactive='1' AND oxvarcount=0 LIMIT 1");
			$artCount = $rs->recordCount();
			//die( print_r($rs));
			$test	  =  $rs->fields[0];
			if ($rs != false)
			{
				$sOXID=$rs->fields[0];
				if ($sOXID)
				{
					 $oArticle = oxNew( "oxarticle");
					 $oArticle->load($sOXID);
					
				}
				else
				{
					$NoArticle = true;
				}
			}
			else
			{
				$NoArticle =true;
			}
			if ($NoArticle)
			{
				//Show user a failure message
				 $oEx = oxNew( 'oxNoArticleException' );
				 $oLang = oxRegistry::get("oxLang");
				 $oEx->setMessage( sprintf($oLang->translateString($sOXID , $oLang->getBaseLanguage() ), $artnum) );
				 oxRegistry::get("oxUtilsView")->addErrorToDisplay( $oEx );
				 $class= oxRegistry::getConfig()->getRequestParameter("cl");
				 oxRegistry::get("oxUtils")->redirect( oxRegistry::get("oxConfig")->getShopHomeURL() .'cl=basket', false, 302 );
			}
			else
			{
				//If article has select lists and/or variants redirect to detail page for further selections...
				$redirect=false;
				if ($oArticle->hasMdVariants())
				{
						
					$oEx = oxNew( 'oxNoArticleException' );
					$oLang = oxRegistry::get("oxLang");
					$oEx->setMessage( "Please choose options first." );
					oxRegistry::get("oxUtilsView")->addErrorToDisplay( $oEx );
					$oxUtils=oxRegistry::get("oxUtils");
					if ( $oxUtils->seoIsActive() )
					{
						$oxdetaillink = oxRegistry::get("oxSeoEncoderArticle")->getArticleUrl( $oArticle);
					}
					else
					{
						$oxdetaillink = $oArticle->getStdLink();
					}
					$oxUtils->redirect( $oxdetaillink, false, 302 );
					$redirect=true;
				}
			}
		}
		parent::tobasket($sOXID,$am);
	}

	public function toBasketMultiple()
	{
		$oConfig = oxRegistry::getConfig();
		$am= oxRegistry::getConfig()->getRequestParameter('am');
		$NoArticle=false;
		$ids = null; 
		$i= 0;
		$fast= oxRegistry::getConfig()->getRequestParameter( 'fast');
		if($fast){
			$arts = $ids = oxRegistry::getConfig()->getRequestParameter("artnum");
			$s = 0; 
			foreach($arts as $art)
			{
				$ids[$s] = $this->getOxidFromArtnum($art);
				$s++;
			}
		}else
		{
			$ids = oxRegistry::getConfig()->getRequestParameter("id");
		}
			foreach($ids as $id)
			{
				if($id != "" && $am[$i] != ""){
					
					parent::tobasket($id,$am[$i]);
				}
				$i++;
			}
	}
}