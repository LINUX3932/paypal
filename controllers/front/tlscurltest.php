<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2018 PrestaShop SA
 *  @version  Release: $Revision: 13573 $
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class PayPalTlscurltestModuleFrontController extends ModuleFrontController
{
    public function displayAjax()
    {
        if (defined('CURL_SSLVERSION_TLSv1_2')) {
            $tls_server = $this->context->link->getModuleLink('paypal', 'tlscurltestserver');
            $curl = curl_init($tls_server);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,true);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,2);
            curl_setopt($curl,CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            $response = curl_exec($curl);
            if($response != 'ok') {
                $curl_info = curl_getinfo($curl);
                if ($curl_info['http_code'] == 401) {
                    echo '<p style="color:red">401 Unauthorized</p>';
                } else {
                    echo '<p style="color:red">'.curl_error($curl).'</p>';
                }
            }
            else {
                echo '<p style="color:green">TLS version is compatible</p>';
            }
        } else {
            echo '<p style="color:red">TLS version is not compatible</p>';
        }

        die;
    }
}