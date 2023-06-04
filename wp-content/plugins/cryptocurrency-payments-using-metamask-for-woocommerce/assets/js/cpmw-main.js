class CpmwWalletExtentionHandler {
    constructor(localvalue) {
        this.wrapperclass = '.cpmw_loader_wrap'
        this.confirmMsg = '.cpmw_loader_wrap .cpmw_loader>div'
        this.paymentPrice = localvalue.in_crypto
        this.localizeval = localvalue
        this.WalletName = ''
        this.WalletObject = ''
        this.WalletLink = ''
        this.networkName = ''
        this.networkId = ''
    }

    /**
    * Check Order Status
    */
    checkOrderStatus() {
        if (this.localizeval.order_status == "on-hold" && this.localizeval.transaction_id != "") {
            this.showPassedClass(this.wrapperclass)
            this.hidePassedClass(this.confirmMsg)
            this.addUserMessage(this.localizeval.payment_msg)
            this.addClassForCss('cpmw_payment_sucess')
        }
        else if (this.localizeval.is_paid == 1) {
            this.showPassedClass(this.wrapperclass)
            this.hidePassedClass(this.confirmMsg)
            this.addUserMessage(this.localizeval.payment_msg)
            this.addClassForCss('cpmw_payment_sucess')
        }
        else if (this.localizeval.order_status == "cancelled") {
            let shop_link = "<br><a href=" + this.localizeval.shop_page + ">Go To Shop</a>"
            this.showPassedClass(this.wrapperclass)
            this.hidePassedClass(this.confirmMsg)
            this.addUserMessage(this.localizeval.rejected_msg + shop_link)
            this.addClassForCss('cpmw_payment_rejected')
        }
        else {
            this.showPassedClass('.cmpw_meta_connect')
        }
    }

    /**
    * 
    * @param {*} selectedWallet 
    * @returns selected wallet object
    */
    async getSelectedWallet() {      
        var wallet_object = window.ethereum;
        this.WalletObject = wallet_object;
        return this.WalletObject;
    }

    /**
     * 
     * @param {Check extention enabled or not}
     * @returns 
     */
    isWalletExtentionEnabled() {  
        if (typeof this.WalletObject === 'undefined' || this.WalletObject === '') {       
            const el = document.createElement('div')
            el.innerHTML = "<a href='https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn?hl=en' target='_blank'>Click Here </a> to install MetaMask extention"
            this.displayPopUp(this.localizeval.const_msg.ext_not_detected, "warning", false, false, el)
            return false;
        }
        return true;
    }

    /**
     * 
     * @param {*} provider 
     * @param {*} wallet_object 
     * Access user account
     */
    async connectUserAccount(provider, wallet_object) {
        this.displayPopUp(this.localizeval.const_msg.connection_establish, false, false, false, false, false, false, true, true)
        let object = this;
        await provider.send("eth_requestAccounts", []).then(function (account_list) {
            let accounts = account_list
            if (accounts[0] != undefined) {
                Swal.close()
                const active_network = object.getActiveNetwork(provider, wallet_object)
                active_network.then(function (networkresult) {
                    if (networkresult.id != object.localizeval.network) {                       
                        object.displayPopUp(object.localizeval.const_msg.required_network, "warning", false, false, false, "Please Switch Network To " + object.localizeval.network_name, false, true, true)                      
                        object.changeNetwork(object.localizeval.network, wallet_object);
                    }
                    else {
                        object.processOrder(provider, wallet_object, accounts)
                   
                    }
                })



            }
        }).catch((err) => {
            console.log(err)
            this.displayPopUp(this.localizeval.const_msg.user_rejected_the_request, 'error', 2000)

        })

    }

    /**
     * 
     * @param {*} provider 
     * @param {*} wallet_object 
     * Call extention
     */
    processOrder(provider, wallet_object, accounts) {
        var object = this
        const active_network = this.getActiveNetwork(provider, wallet_object)
        active_network.then(function (networkresult) {
            jQuery('.cmpw_meta_wrapper .active-chain p.cpmw_active_chain').html(networkresult.name);
        })

        jQuery('.cmpw_meta_wrapper .connected-account .account-address').append(accounts);
        this.hidePassedClass('.cmpw_meta_connect')
        this.showPassedClass('.cmpw_meta_wrapper')
        active_network.then(function (networkresult) {
            if (networkresult.id != object.localizeval.network) {               
                object.displayPopUp(object.localizeval.const_msg.required_network, "warning", false, false, false, "Please Switch Network To " + object.localizeval.network_name, false, true, true)                
                object.changeNetwork(object.localizeval.network, wallet_object);               
            }
        })


        jQuery('.pay-btn-wrapper button').on("click", function (params) {
            active_network.then(function (networkresult) {
                if (networkresult.id != object.localizeval.network) {
                    object.displayPopUp(object.localizeval.const_msg.required_network, "warning", false, false, false, object.localizeval.const_msg.switch_network + object.localizeval.network_name, true).then((result) => {
                        if (result.isConfirmed) {
                            object.changeNetwork(object.localizeval.network, wallet_object);
                        }
                    })
                }
                else {
                    object.callMainNetwork(provider, accounts[0], wallet_object);
                }
            })

        })

    }

    /**
     * 
     * @param {*} provider 
     * @param {*} accounts 
     * Initiate Payment Process
     */
    callMainNetwork(provider, accounts, wallet_object) {
        jQuery('.pay-btn-wrapper button').removeAttr('disabled')
        const confirm_payment = document.createElement('div')
        confirm_payment.innerHTML = this.localizeval.in_crypto + this.localizeval.currency_symbol

        this.displayPopUp(this.localizeval.const_msg.confirm_order, "warning", false, false, confirm_payment, false, true, false, false, 'Confirm').then(async (result) => {
            if (result.isConfirmed) {
                this.callMainNetworkCurrency(accounts, provider)
            }
        })
    }


    /**
     * 
     * @param {*} account 
     * @param {*} provider 
     * Process Main network currency
     */
    callMainNetworkCurrency(account, provider) {
        this.displayPopUp(this.localizeval.confirm_msg, false, this.localizeval.url + "/assets/images/metamask.png", false, false, false, false, true, true)

        let contract_address = this.localizeval.token_address;
        let default_currency = ["ETH", "BNB"];
        if (jQuery.inArray(this.localizeval.currency_symbol, default_currency) == -1) {
            this.callNetworkTokens(contract_address, this.localizeval.recever, provider);
        }
        else {
            // Methods that require user authorization like this one will prompt a user interaction.
            // Other methods (like reading from the blockchain) may not.
            try {

                const signer = provider.getSigner()
                var secret_code = "";
                const tx = {
                    from: account,
                    to: this.localizeval.recever,
                    value: ethers.utils.parseEther(this.paymentPrice)._hex,
                    gasLimit: ethers.utils.hexlify("0x5208"), // 21000

                }
                var object = this;
                const trans = signer.sendTransaction(tx).then(async function (res) {
                    Swal.close()

                    const process_messsage = document.createElement('div')
                    process_messsage.innerHTML = '<p class="cpmw_transaction_note">' + object.localizeval.const_msg.notice_msg + '</p>';
                    Swal.fire({
                        title: object.localizeval.process_msg,
                        imageUrl: object.localizeval.url + "/assets/images/metamask.png",                      
                        footer: process_messsage,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        allowOutsideClick: false,
                    })
                    object.hidePassedClass('.cpmw_loader_wrap .cpmw_loader>div')
                    object.saveTransactionToken(res.hash, account)
                    return res.wait();
                }).then(function (tx) {

                    object.hidePassedClass('.cmpw_meta_wrapper')
                    object.showPassedClass('.cpmw_loader_wrap')
                    object.addUserMessage(object.localizeval.payment_msg)
                    object.addClassForCss('cpmw_payment_sucess')
                    object.ajaxCallHandler(tx.transactionHash, false, secret_code, account)

                }).catch(function (error) {

                    if (error.code == "4001") {
                        let shop_link = "<br><a href=" + object.localizeval.shop_page + ">Go To Shop</a>"
                        object.displayPopUp(object.localizeval.rejected_msg, false, object.localizeval.url + "/assets/images/metamask.png", 2000)
                        object.hidePassedClass('.cmpw_meta_wrapper')
                        object.addUserMessage(object.localizeval.rejected_msg + shop_link)
                        object.addClassForCss('cpmw_payment_rejected')
                        object.ajaxCallHandler(false, true, "", "")
                        return;
                    }
                    else if (error.error == "Rejected by user") {
                        let shop_link = "<br><a href=" + object.localizeval.shop_page + ">Go To Shop</a>"
                        object.displayPopUp(object.localizeval.rejected_msg, false, object.localizeval.url + "/assets/images/metamask.png", 2000)
                        object.hidePassedClass('.cmpw_meta_wrapper')
                        object.hidePassedClass('.cpmw_loader_wrap .cpmw_loader>div')
                        object.addUserMessage(object.localizeval.rejected_msg + shop_link)
                        object.addClassForCss('cpmw_payment_rejected')
                        object.ajaxCallHandler(false, true, "", "")
                        return;

                    }
                    else {
                        object.displayPopUp(error.message, false, object.localizeval.url + "/assets/images/metamask.png", 5000)
                    }
                });
            }
            catch (erro) {
                console.log(erro)
            }

        }

        }

    /**
     * 
     * @param {*} transaction 
     * @param {*} rejected 
     * @param {*} secret_code 
     * @param {*} from 
     * Ajax call handling
     */
        ajaxCallHandler(transaction, rejected, secret_code, from) {
            let sender = String(from);
            let object = this;

            var request_data = {
                'action': 'cpmw_payment_verify',
                'nonce': this.localizeval.nonce,
                'order_id': this.localizeval.id,
                'payment_status': this.localizeval.payment_status,
                'payment_processed': transaction,
                'rejected_transaction': rejected,
                'selected_network': this.localizeval.network,
                'sender': sender,
                'recever': this.localizeval.recever,
                'amount': this.localizeval.in_crypto,
                'secret_code': secret_code,
            };
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: this.localizeval.ajax,
                data: request_data,
                success: function (data) {
                    Swal.close()
                    if (data.order_status == "cancelled") {
                        let shop_link = "<br><a href=" + object.localizeval.shop_page + ">Go To Shop</a>"
                        object.showPassedClass('.cpmw_loader_wrap')
                        object.hidePassedClass('.cpmw_loader_wrap.cpmw_loader > div')
                        object.addUserMessage(object.localizeval.rejected_msg + shop_link)
                        object.addClassForCss('cpmw_payment_rejected')
                    }
                    if (data.is_paid == true) {
                        object.hidePassedClass('.cmpw_meta_wrapper')
                        object.showPassedClass('.cpmw_loader_wrap')
                        object.addUserMessage(object.localizeval.payment_msg)
                        object.addClassForCss('cpmw_payment_sucess')
                        object.displayPopUp(object.localizeval.payment_msg, false, object.localizeval.url + "/assets/images/metamask.png").then((result) => {
                            if (result.isConfirmed) {
                                if (object.localizeval.redirect != "") {
                                    window.location.href = object.localizeval.redirect;
                                }
                                else {
                                    location.reload();
                                }
                            }
                        })


                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    object.displayPopUp('Error code:' + textStatus, 'error', false, false, false, errorThrown)
                    console.log("Status: " + textStatus + "Error: " + errorThrown);
                }
            })

        }


    /**
     * 
     * @param {*} txhash 
     * @param {*} account 
     * Save token in database
     */
    saveTransactionToken(txhash, account) {

        var request_data = {
            'action': 'cpmw_get_transaction_hash',
            'nonce': this.localizeval.nonce,
            'order_id': this.localizeval.id,
            'transaction_id': txhash,
            'payment_status': this.localizeval.payment_status,
            'selected_network': this.localizeval.network,
            'sender': account,
            'recever': this.localizeval.recever,
            'amount': this.localizeval.in_crypto
        };
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: this.localizeval.ajax,
            data: request_data,
            success: function (data) {
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus + "Error: " + errorThrown);
            }
        })

    }

    /**
     * 
     * @param {*} contract_address 
     * @param {*} to_address 
     * @param {*} provider 
     * Process Token Payment
     */
    async callNetworkTokens(contract_address, to_address, provider) {

        if (contract_address) {
            var object = this
            // The ERC-20 ABI
            try {
                var abi = [
                    "function name() view returns (string)",
                    "function symbol() view returns (string)",
                    "function gimmeSome() external",
                    "function balanceOf(address _owner) public view returns (uint256 balance)",
                    "function transfer(address _to, uint256 _value) public returns (bool success)",
                    "function decimals() view returns (uint256)",
                ];
                const signer = provider.getSigner();
                let userAddress = await signer.getAddress();
                var address = contract_address;
                var contract = new ethers.Contract(address, abi, signer);
                var secret_code = ""
                const decimals = await contract.decimals();
                var amount = ethers.utils.parseUnits(this.paymentPrice, decimals);
                let Balance = await contract.balanceOf(userAddress).then(function (balance) {
                    var text = ethers.utils.formatUnits(balance, decimals);
                    if (Number(text) >= object.paymentPrice) {
                        contract.transfer(to_address, amount).then(function (tx) {
                            Swal.close()
                            const process_messsage = document.createElement('div')
                            process_messsage.innerHTML = '<p class="cpmw_transaction_note">' + extradata.const_msg.notice_msg + '</p>';
                            Swal.fire({
                                title: extradata.process_msg,
                                imageUrl: object.localizeval.url + "/assets/images/metamask.png",
                                footer: process_messsage,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                allowOutsideClick: false,
                            })
                            // Show the pending transaction   
                            object.saveTransactionToken(tx.hash, userAddress)

                            return tx.wait();
                        }).then(function (tx) {
                            object.ajaxCallHandler(tx.transactionHash, false, secret_code, userAddress)

                        }).catch(function (error) {
                            console.log(error)
                            if (error.code == "4001") {
                                let shop_link = "<br><a href=" + object.localizeval.shop_page + ">Go To Shop</a>"
                                object.displayPopUp(object.localizeval.rejected_msg, false, object.localizeval.url + "/assets/images/metamask.png", 2000)
                                object.hidePassedClass('.cmpw_meta_wrapper')
                                object.addUserMessage(object.localizeval.rejected_msg + shop_link)
                                object.addClassForCss('cpmw_payment_rejected')
                                object.ajaxCallHandler(false, true, "", "")
                                return;
                            }
                            else if (error.error == "Rejected by user") {
                                let shop_link = "<br><a href=" + object.localizeval.shop_page + ">Go To Shop</a>"
                                object.displayPopUp(object.localizeval.rejected_msg, false, object.localizeval.url + "/assets/images/metamask.png", 2000)
                                object.hidePassedClass('.cmpw_meta_wrapper')
                                object.hidePassedClass('.cpmw_loader_wrap .cpmw_loader>div')
                                object.addUserMessage(object.localizeval.rejected_msg + shop_link)
                                object.addClassForCss('cpmw_payment_rejected')
                                object.ajaxCallHandler(false, true, "", "")
                                return;

                            }
                            else {
                                object.displayPopUp(error, 'error', false, false, false, error.message)
                            }
                        });
                    }
                    else {

                        object.displayPopUp(extradata.const_msg.insufficient_balance + text, false, object.localizeval.url + "/assets/images/metamask.png")
                        object.hidePassedClass('.cpmw_loader_wrap .cpmw_loader>div')
                        object.addUserMessage(extradata.const_msg.insufficient_balance + text)
                    }
                })
            }
            catch (error) {
                console.log(error)

                if (error.code == "-32000" || error.code == "-32603") {
                    this.displayPopUp(extradata.const_msg.insufficient_balance, false, this.localizeval.wallet_image)

                }
                else {
                    this.displayPopUp(error.message, 'error')

                }

            }


        }

    }

    /**
     * 
     * @param {pass required chainid} chain_id 
     * @param {wallet object} wallet_object 
     */
    async changeNetwork(chain_id, wallet_object) {
        try {
            const chain_change = await wallet_object.request({
                method: 'wallet_switchEthereumChain',
                params: [{ chainId: chain_id }],
            });
            jQuery('.pay-btn-wrapper button').attr('disabled', 'disabled');
            location.reload();
        } catch (switchError) {
            console.log(switchError)
            // This error code indicates that the chain has not been added to MetaMask.
            if (switchError.code === 4902) {
                try {
                    wallet_object.request({
                        method: 'wallet_addEthereumChain',
                        params: Array(JSON.parse(this.localizeval.network_data)),
                    }).catch((error) => {
                        this.displayPopUp('Error code:' + error.code, "error", false, false, false, error.message)
                    });
                } catch (addError) {
                    // handle "add" error
                }
            }
            else {
                this.displayPopUp(switchError.message, "error")
            }
            // handle other "switch" errors
        }
    }

    /**
     * 
     * @param {*} provider 
     * @param {*} wallet_object 
     * @returns currently active network
     */
    async getActiveNetwork(provider, wallet_object) {

        const network = await provider.getNetwork()
        let activechain_id = '0x' + Number(network.chainId).toString(16);

        const active_network = (Object.keys(this.localizeval.supported_networks).includes(activechain_id)) ? this.localizeval.supported_networks[activechain_id] : network.name;
        this.networkName = active_network
        this.networkId = activechain_id
        return { name: active_network, id: activechain_id };
    }



    /**
    * 
    * @param {*} classnames 
    * Display Mentioned Class
    */
    showPassedClass(classnames) {
        jQuery(classnames).show();
    }

    /**
     * 
     * @param {*} classnames
     * Hide Mentioned Class 
     */
    hidePassedClass(classnames) {
        jQuery(classnames).hide();
    }

    /**
     * 
     * @param {*} cssClass
     * add class to html 
     */
    addClassForCss(cssClass) {
        jQuery('.cpmw_loader_wrap .cpmw_loader h2 span').addClass(cssClass)
    }

    /**
     * 
     * @param {*} message 
     * add dyncamic message
     */
    addUserMessage(message) {
        jQuery('.cpmw_loader_wrap .cpmw_loader h2').html("<span>" + message + "</span>");
    }

    /**
     * 
     * @param {receve custom message} msg 
     * @param {icon class} icons 
     * @param {image url} image 
     * @param {timer} time 
     * @param {html} htmls 
     * 
     */
    displayPopUp(msg, icons = false, image = false, time = false, htmls = false, text = false, cancelbtn = false, showloder = false, outsideclick = false, confirmtxt = "Ok", endsession = false) {
        Swal.close()
        let object = Swal.fire({
            title: msg,
            text: text,
            customClass: { container: 'cpmw_main_popup_wrap', popup: 'cpmw_popup' },
            icon: icons,
            html: htmls,
            showCancelButton: cancelbtn,
            confirmButtonColor: '#3085d6',
            confirmButtonText: confirmtxt,
            reverseButtons: true,
            imageUrl: image,
            timer: time,
            didOpen: () => {
                (showloder == true) ? Swal.showLoading() : false
            },
            allowOutsideClick: outsideclick,

        })
        return object;

    }

}
const Wallets = new CpmwWalletExtentionHandler(extradata);

Wallets.checkOrderStatus();
jQuery('.cmpw_meta_connect .cpmw_connect_btn button').on("click", async function (params) {
    Wallets.getSelectedWallet().then(async function () {
        let extentionEnabled = Wallets.isWalletExtentionEnabled()
        if (extentionEnabled == true) {
            const provider = new ethers.providers.Web3Provider(Wallets.WalletObject);
            let accounts = await provider.listAccounts();
            if (accounts.length == 0) {
                Wallets.connectUserAccount(provider, Wallets.WalletObject)
            }
            else {
                Wallets.processOrder(provider, Wallets.WalletObject, accounts)
            }
        }

    })
})
if (extradata.is_paid != 1 && extradata.order_status != "cancelled") {
    jQuery('.cmpw_meta_connect .cpmw_connect_btn button').trigger("click");
}