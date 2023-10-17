<?php

namespace BeycanPress\CryptoPay;

class Lang
{
    public static function get() : array
    {
        return [
            "selectNetwork" => esc_html__('Select network', 'cryptopay'),
            "orderId" => esc_html__('Order ID:', 'cryptopay'),
            "orderAmount" => esc_html__('Order amount:', 'cryptopay'),
            "selectedNetwork" => esc_html__('Selected network:', 'cryptopay'),
            "waitingBlockConfirmations" => esc_html__('Waiting for block confirmations:', 'cryptopay'),
            "waitingTransactionConfirmations" => esc_html__('Waiting for transaction confirmation...', 'cryptopay'),
            "openInExplorer" => esc_html__('Open in explorer', 'cryptopay'),
            "waitingConfirmation" => esc_html__('Waiting confirmation...', 'cryptopay'),
            "selectWallet" => esc_html__('Select wallet', 'cryptopay'),
            "pleaseTryToConnectAgain" => esc_html__('Please try to connect again by selecting network {networkName} from your wallet!', 'cryptopay'),
            "walletConnectionTimedOut" => esc_html__('Wallet connection timed out!', 'cryptopay'),
            "connectionError" => esc_html__('Connection error!', 'cryptopay'),
            "paymentCurrency" => esc_html__('Payment currency:', 'cryptopay'),
            "amountToBePaid" => esc_html__('Amount to be paid:', 'cryptopay'),
            "payNow" => esc_html__('Pay now', 'cryptopay'),
            "payWith" => esc_html__('Pay with {name}', 'cryptopay'),
            "loading" => esc_html__('Loading...', 'cryptopay'),
            "waitingApproval" => esc_html__('Waiting approval...', 'cryptopay'),
            "paymentRejected" => esc_html__('Payment rejected!', 'cryptopay'),
            "transferAmountError" => esc_html__('Transfer amount need to be bigger from zero!', 'cryptopay'),
            "transactionCreateFail" => esc_html__('Transaction create fail!', 'cryptopay'),
            "pleaseTryAgain" => esc_html__('Please try again!', 'cryptopay'),
            "insufficientBalance" => esc_html__('Insufficient balance!', 'cryptopay'),
            "openWallet" => esc_html__('Open wallet', 'cryptopay'),
            "paymentAddress" => esc_html__('Payment address:', 'cryptopay'),
            "paymentTimedOut" => esc_html__('Payment timed out!', 'cryptopay'),
            "connectionRejected" => esc_html__('Connection rejected!', 'cryptopay'),
            "pleaseWait" => esc_html__('Please wait...', 'cryptopay'),
            "convertingError" => esc_html__('There was a problem converting currency! Make sure your currency value is available in the relevant API or you define a custom value for your currency.', 'cryptopay'),
            "transactionSent" => esc_html__('Transaction sent', 'cryptopay'),
            "notFoundAnyWallet" => esc_html__('No working wallet or qr payment service was found on this network. Please make sure you have a {networkName} wallet working on the browser or contact the administrator regarding the situation.', 'cryptopay'),
            "alreadyProcessing" => esc_html__('There is currently a process on the wallet. Please try again after completing the relevant process.', 'cryptopay'),
            "wallet-not-found" => esc_html__('Wallet not found!', 'cryptopay'),
            "rpcAccessForbidden" => esc_html__('RPC Address refused to connect (This is not an error!). Blockchain networks main RCP API addresses are public, so it can restrict you, in which case you need to get a unique RPC API address from any provider as stated in the documentation. Please report the situation to the site administrator.', 'cryptopay'),
            "invalidAddress" => esc_html__('Failed to match network with corresponding payout wallet. Please notify the site administrator of the situation.', 'cryptopay'),
            "anyError" => esc_html__('An unexpected error has occurred, please try again or contact the site administrator.', 'cryptopay'),
            "continuePaymentProcess" => esc_html__('Continue payment process', 'cryptopay'),
            'defaultErrorMsg' => esc_html__('Error processing checkout. Please try again.', 'cryptopay'),
            "checkingForm" => esc_html__('Checking form data! Please wait...', 'cryptopay'),
            "qrCodePaymentMsg" => esc_html__('Payment has been received, but there are mandatory fields in the payment form. Please click the "Continue payment process" button after completing them.', 'cryptopay'),
            "tokenMetadataNotFound" => esc_html__('Token metadata not found!', 'cryptopay'),
            "payQr" => esc_html__('Pay by transfer to address (QR Code)', 'cryptopay'),
            "moralisApiKeyNotSet" => esc_html__('Moralis API key not set! Please contact the site administrator.', 'cryptopay'),
            "qrCode" => esc_html__('QR Code', 'cryptopay'),
            "detected" => esc_html__('Detected', 'cryptopay'),
            "download" => esc_html__('Download', 'cryptopay'),
            "openInApp" => esc_html__('Open In App', 'cryptopay'),
            "websocketConnectionFailed" => esc_html__('Websocket connection failed!', 'cryptopay'),
            "websocketNotSupported" => esc_html__('A transaction was caught, but execution aborted due to an error on Websocket. Please specify a supported Websocket address.', 'cryptopay'),
            "corsError" => esc_html__('You cannot connect to the websocket server because your domain is not in the list of allowed domains.', 'cryptopay'),
            "change" => esc_html__('Change', 'cryptopay'),
            "changeNetwork" => esc_html__('Change network', 'cryptopay'),
            "ensDomain" => esc_html__('ENS Domain: ', 'cryptopay'),
            "notFoundAnyCurrency" => esc_html__('No active currencies were found on this network. Please report this to the administrator.', 'cryptopay'),
            "paymentCompleting" => esc_html__('Payment is being completed, please wait...', 'cryptopay'),
        ];
    }

}