<?php
    function payment_pro_crypt($string)
    {
        $cypher = MCRYPT_RIJNDAEL_256;
        $mode = MCRYPT_MODE_ECB;
        return base64_encode(mcrypt_encrypt($cypher, PAYMENT_PRO_CRYPT_KEY, $string, $mode,
            mcrypt_create_iv(mcrypt_get_iv_size($cypher, $mode), MCRYPT_RAND)
            ));
    }

    function payment_pro_decrypt($string)
    {
        if($string=='') { return ''; };
        $cypher = MCRYPT_RIJNDAEL_256;
        $mode = MCRYPT_MODE_ECB;
        return str_replace("\0", "", mcrypt_decrypt($cypher, PAYMENT_PRO_CRYPT_KEY,  base64_decode($string), $mode,
            mcrypt_create_iv(mcrypt_get_iv_size($cypher, $mode), MCRYPT_RAND)
            ));
    }

    function payment_pro_format_btc($btc, $symbol = "BTC") {
        if($btc<0.00001) {
            return ($btc*1000000).'µ'.$symbol;
        } else if($btc<0.01) {
            return ($btc*1000).'m'.$symbol;
        }
        return $btc.$symbol;
    }

    function payment_pro_set_custom($str = null) {
        return payment_pro_crypt(json_encode($str));
    }

    function payment_pro_get_custom($str) {
        return json_decode(payment_pro_decrypt(str_replace(" ", "+", $str)), true);
    }

    function payment_pro_wallet_button($amount = '0.00', $description = '', $itemnumber = '101', $extra_array = '||') {
        $extra = payment_pro_set_custom($extra_array);
        $extra .= 'concept,'.$description.'|';
        $extra .= 'product,'.$itemnumber.'|';

        echo '<a href="'.osc_route_url('payment-pro-wallet', array('a' => $amount, 'desc' => $description, 'extra' => $extra)).'"><button>'.__("Pay with your credit", 'payment_pro').'</button></a>';
    }

    function payment_pro_js_redirect_to($url) { ?>
        <script type="text/javascript">
            window.top.location.href = "<?php echo $url; ?>";
        </script>
    <?php }

    function payment_pro_buttons($products, $extra = null) {
        $services = View::newInstance()->_get('_payment_pro_services');
        if(is_array($services)) {
            foreach ($services as $service => $file) {
                $payment = Payment::newInstance($service);
                if($payment) {
                    $payment->button($products, $extra);
                }
            };
        } else {
            _e('No method of payment is available', 'payment_pro');
        };
    }

    function payment_pro_recurring_buttons($products, $extra = null) {
        $services = View::newInstance()->_get('_payment_pro_services');
        if(is_array($services)) {
            foreach ($services as $service => $file) {
                $payment = Payment::newInstance($service);
                if($payment) {
                    $payment->recurringButton($products, $extra);
                }
            };
        } else {
            _e('No method of payment is available', 'payment_pro');
        };
    }

    function payment_pro_send_email($email) {

        $item = Item::newInstance()->findByPrimaryKey($email['fk_i_item_id']);
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('payment_pro_email_payment') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }

        $item_url    = osc_item_url( ) ;
        $item_url    = '<a href="' . $item_url . '" >' . $item_url . '</a>';
        $publish_url = osc_route_url('payment-pro-addcart', array('item' => 'PUB' . $item['fk_i_category_id'] . '-' . $item['pk_i_id']));
        $premium_url = osc_route_url('payment-pro-addcart', array('item' => 'PRM' . $item['fk_i_category_id'] . '-' . $item['pk_i_id']));

        $words   = array();
        $words[] = array('{ITEM_ID}', '{CONTACT_NAME}', '{CONTACT_EMAIL}', '{WEB_URL}', '{ITEM_TITLE}',
            '{ITEM_URL}', '{WEB_TITLE}', '{PUBLISH_LINK}', '{PUBLISH_URL}', '{PREMIUM_LINK}', '{PREMIUM_URL}',
            '{START_PUBLISH_FEE}', '{END_PUBLISH_FEE}', '{START_PREMIUM_FEE}', '{END_PREMIUM_FEE}');
        $words[] = array($item['pk_i_id'], $item['s_contact_name'], $item['s_contact_email'], osc_base_url(), $item['s_title'],
            $item_url, osc_page_title(), '<a href="' . $publish_url . '">' . $publish_url . '</a>', $publish_url, '<a href="' . $premium_url . '">' . $premium_url . '</a>', $premium_url, '', '', '', '') ;

        if($email['b_publish']==0) {
            $content['s_text'] = preg_replace('|{START_PUBLISH_FEE}(.*){END_PUBLISH_FEE}|', '', $content['s_text']);
        }

        if($email['b_premium']==0) {
            $content['s_text'] = preg_replace('|{START_PREMIUM_FEE}(.*){END_PREMIUM_FEE}|', '', $content['s_text']);
        }

        $title = osc_apply_filter('alert_email_payment_pro_title_after', osc_mailBeauty(osc_apply_filter('email_payment_pro_title', osc_apply_filter('alert_email_payment_pro_title', $content['s_title'], $email, $item)), $words), $email, $item);
        $body  = osc_apply_filter('alert_email_payment_pro_description_after', osc_mailBeauty(osc_apply_filter('email_payment_pro_description', osc_apply_filter('alert_email_payment_pro_description', $content['s_text'], $email, $item)), $words), $email, $item);

        $emailParams =  array('subject'  => $title
        ,'to'       => $item['s_contact_email']
        ,'to_name'  => $item['s_contact_name']
        ,'body'     => $body
        ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }

    function payment_pro_cart_add($id, $description, $amount, $quantity = 1, $tax = 0, $extra = null) {
        if(!is_numeric($amount) || !is_numeric($quantity) || $quantity<=0) {
            return false;
        }
        $items = Session::newInstance()->_get('_payment_pro_cart_items');
        if(isset($items[$id])) {
            $items[$id]['quantity'] = osc_apply_filter('payment_pro_add_quantity', ($items[$id]['quantity']+$quantity), $items[$id]);
            $items[$id]['extra'] = osc_apply_filter('payment_pro_add_extra', $extra, $items[$id]);
        } else {
            $items[$id] = osc_apply_filter('payment_pro_add_to_cart', array(
                'id' => $id,
                'description' => $description,
                'amount' => $amount,
                'tax' => $tax,
                'quantity' => $quantity,
                'extra' => $extra
            ));
        }
        Session::newInstance()->_set('_payment_pro_cart_items', $items);
        return true;
    }

    function payment_pro_cart_get() {
        $items = Session::newInstance()->_get('_payment_pro_cart_items');
        if(is_array($items)) {
            return $items;
        }
        return array();
    }

    function payment_pro_cart_drop($id = null) {
        if($id!=null) {
            $items = Session::newInstance()->_get('_payment_pro_cart_items');
            if(isset($items[$id])) {
                unset($items[$id]);
            }
            Session::newInstance()->_set('_payment_pro_cart_items', $items);
            return true;
        }
        Session::newInstance()->_drop('_payment_pro_cart_items');
        return true;
    }

    function payment_pro_register_service($name, $file) {
        $services = json_decode(osc_get_preference('services', 'payment_pro'), true);
        $tmp = explode('plugins/payment_pro/', $file);
        if(count($tmp)>1) {
            $file = PAYMENT_PRO_PATH . preg_replace('|^' . $tmp[0] . 'plugins/payment_pro/|', '', $file);
        }
        $services[$name] = $file;
        osc_set_preference('services', json_encode($services), 'payment_pro');
        osc_reset_preferences();
    }

    function payment_pro_unregister_service($name) {
        $services = json_decode(osc_get_preference('services', 'payment_pro'), true);
        unset($services[$name]);
        osc_set_preference('services', json_encode($services), 'payment_pro');
        osc_reset_preferences();
    }

    function payment_pro_check_items($items, $total, $error = 0.15) {
        $subtotal = 0;
        foreach($items as $item) {
            if(isset($item['amount_total'])) {
                $subtotal += $item['amount_total'];
            } else {
                $subtotal += $item['amount']*$item['quantity']*((100+$item['tax'])/100);
            }
            $str = substr($item['id'], 0, 3);
            if($str=='PUB') {
                $cat = explode("-", $item['id']);
                $price = ModelPaymentPro::newInstance()->getPublishPrice(substr($cat[0], 3));
                if($item['quantity']!=1 || $price['price']!=$item['amount']) {
                    return PAYMENT_PRO_WRONG_AMOUNT_ITEM;
                }
            } if($str=='PRM') {
                $cat = explode("-", $item['id']);
                $price = ModelPaymentPro::newInstance()->getPremiumPrice(substr($cat[0], 3));
                if($item['quantity']!=1 || $price['price']!=$item['amount']) {
                    return PAYMENT_PRO_WRONG_AMOUNT_ITEM;
                }
            } else {
                $correct_price = osc_apply_filter('payment_pro_price_' . strtolower($str), true, $item);
                if(!$correct_price) {
                    return PAYMENT_PRO_WRONG_AMOUNT_ITEM;
                }
            }
        }
        if(abs($subtotal-$total)>($total*$error)) {
            return PAYMENT_PRO_WRONG_AMOUNT_TOTAL;
        }
        return PAYMENT_PRO_COMPLETED;
    }

    function payment_pro_do_404() {
        ob_get_clean();
        Rewrite::newInstance()->set_location('error');
        header('HTTP/1.1 404 Not Found');
        osc_current_web_theme_path('404.php');
        exit;
    }

    function payment_pro_complete_item($item) {
        if(!isset($item['tax'])) {
            $item['tax'] = 0;
            if(isset($item['amount_tax'])) {
                $item['tax'] = $item['amount_tax']/$item['quantity'];
            } else if (isset($item['amount_total'])) {
                $item['tax'] = (100*$item['amount_total']/$item['amount'])-100;
            }
        }
        if(!isset($item['amount_total'])) {
            $item['amount_total'] = $item['amount']*$item['quantity']*((100+$item['tax'])/100);
        }
        if(!isset($item['amount_tax'])) {
            $item['amount_tax'] = $item['amount']*$item['quantity']*($item['tax']/100);
        }
        return $item;
    }

    function payment_pro_format_price($price, $symbol = null) {

        if($symbol==null) { $symbol = osc_item_currency_symbol(); }

        $price = $price/1000000;

        $currencyFormat = osc_locale_currency_format();
        $currencyFormat = str_replace('{NUMBER}', number_format($price, osc_locale_num_dec(), osc_locale_dec_point(), osc_locale_thousands_sep()), $currencyFormat);
        $currencyFormat = str_replace('{CURRENCY}', $symbol, $currencyFormat);
        return osc_apply_filter('item_price', $currencyFormat );
    }

    function payment_pro_is_highlighted($id = null) {
        if($id==null) {
            $id = osc_item_id();
            if($id==0) {
                return false;
            }
        }
        return ModelPaymentPro::newInstance()->isHighlighted($id);
    }

    function payment_pro_print_highlight_class($id = null) {
        if (payment_pro_is_highlighted($id)) {
            echo " payment-pro-highlighted ";
        }
    }
    osc_add_hook('highlight_class', 'payment_pro_print_highlight_class');

    function payment_pro_invoice_to_items($products) {

        foreach($products as $k => $p) {
            $products[$k]['description'] = $p['s_concept'];
            $products[$k]['amount'] = $p['i_amount']/1000000;
            $products[$k]['tax'] = $p['i_tax']/100;
            $products[$k]['amount_tax'] = $p['i_amount_tax']/1000000;
            $products[$k]['amount_total'] = $p['i_amount_total']/1000000;
            $products[$k]['quantity'] = $p['i_quantity'];
            $products[$k]['item_id'] = $p['fk_i_item_id'];
            $products[$k]['id'] = $p['i_product_type'];
        }

        return $products;
    }

    function payment_pro_tx_link($code, $source) {
        $template = '<a href="%s">%s</a>';
        if($source=='PAYPAL') {
            $url = 'https://www.paypal.com/uk/cgi-bin/webscr?cmd=_view-a-trans&id=' . $code;
            return sprintf($template, $url, $code);
        } else if($source=='STRIPE') {
            if(substr($code, 0, 2)=="in") {
                $url = 'https://dashboard.stripe.com/invoices/' . $code;
            } else {
                $url = 'https://dashboard.stripe.com/payments/' . $code;
            }
            return sprintf($template, $url, $code);
        }
        return $code;
    }
