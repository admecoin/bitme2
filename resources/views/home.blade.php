@include('header')
<section class="banner">
				<div class="container">
					<h2 class="title">A peer-to-peer cryptocurrency exchange</h2>
				</div>
			</section>
			<!-- feature section -->
			<section class="feature">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 col-md-4 col-lg-4">
							<h3>Quick.</h3>
							<p>Money in your account within minutes.* Use any payment method in 130+ countries.</p>
						</div>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<h3>Friendly.</h3>
							<p>A trading interface built for all audiences. No KYC required—begin trading in 30 seconds!</p>
						</div>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<h3>Safe.</h3>
							<p>The only marketplace that’s self-custodial and end-to-end encrypted.</p>
						</div>
					</div>
				</div>
			</section>
			<!-- payment methodes section -->
			<section class="payment">
				<div class="container">
					<div class="pay-method">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<a class="button-cta" href="#">View buy &amp; sell offers</a>
								<p>Choose from more than 30 payment methods.</p>
								<div class="payment-methods-row">         
									<img src="{{ url('/') }}/assets/image/payment/AdvCash.svg" alt="AdvCash">
									<img src="{{ url('/') }}/assets/image/payment/AliPay.svg" alt="AliPay">
									<img src="{{ url('/') }}/assets/image/payment/CashInPerson.svg" alt="Cash in person">
									<img src="{{ url('/') }}/assets/image/payment/GiftCard.svg" alt="Gift card">
									<img src="{{ url('/') }}/assets/image/payment/Interac.svg" alt="Interac">
									<img src="{{ url('/') }}/assets/image/payment/M-PESA.svg" alt="M-PESA">
									<img src="{{ url('/') }}/assets/image/payment/MercadoPago.svg" alt="Mercado Pago">
									<img src="{{ url('/') }}/assets/image/payment/MoneyGram.svg" alt="MoneyGram">
									<img src="{{ url('/') }}/assets/image/payment/PayPal.svg" alt="PayPal">
								</div>
								<div class="payment-methods-row">
									<img src="{{ url('/') }}/assets/image/payment/QIWI.svg" alt="QIWI">
									<img src="{{ url('/') }}/assets/image/payment/SEPA.svg" alt="SEPA">
									<img src="{{ url('/') }}/assets/image/payment/Skrill.svg" alt="Skrill">
									<img src="{{ url('/') }}/assets/image/payment/TransferWise.svg" alt="TransferWise">
									<img src="{{ url('/') }}/assets/image/payment/Venmo.svg" alt="Venmo">
									<img src="{{ url('/') }}/assets/image/payment/WeChatPay.svg" alt="WeChat Pay">
									<img src="{{ url('/') }}/assets/image/payment/WebMoney.svg" alt="WebMoney">
									<img src="{{ url('/') }}/assets/image/payment/WesternUnion.svg" alt="Western Union">
									<img src="{{ url('/') }}/assets/image/payment/Yandex.Money.svg" alt="Yandex.Money">
								</div>
								<p class="note">* Most trades complete in a few minutes, however this largely depends on the chosen payment method.</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- testimonial section -->
			<section class="testimonial">
				<div class="container">
					<h3>What our <span class="live-user-count">106,493</span> users are saying:</h3>
					<div class="testimonial split-half">
						<blockquote>
							<p>Crypscrow is the fast and secure way to make Ethereum trades.</p>
							<footer>— Anonymous, Russia</footer>
						</blockquote>
						<blockquote>
							<p>Thanks to LE, I can earn money securely and save myself from hyperinflation.</p>
							<footer>— Anonymous, Venezuela</footer>
						</blockquote>
					</div>
				</div>
			</section>
			<!-- How it Works  -->
			<section class="how-it-works">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="vertical-rule"></div>
							<h2>How Crypscrow works</h2>
							<div class="steps">
								<div class="step-1 split-half">
									<div>
										<img src="{{ url('/') }}/assets/image/1.png" width="402" height="391">
									</div>
									<div>
										<h3>1. See who’s buying &amp; selling.</h3>
										<p>Consider the “offers”. Anyone in the world can post a bid to buy or sell ETH. Offers can be filtered by payment method, currency, location and popularity.</p>
										<p>From bank transfers to gift cards—every payment method is allowed.</p>
									</div>
								</div>
								<div class="step-2 split-half">
									<div>
										<h3>2. Open a trade.</h3>
										<p>Find an offer you’re happy with and open a trade with the user. Choose the amount you want to buy or sell, and lock the rate in.</p>
									</div>
									<div>
										<img src="{{ url('/') }}/assets/image/2.png" width="375" height="209">
									</div>
								</div>
								<div class="step-3 split-half">
									<div>
										<img src="{{ url('/') }}/assets/image/3.png" width="319" height="163">
									</div>
									<div>
										<h3>3. Make the exchange.</h3>
										<p>After the seller puts the ETH in an escrow account, the buyer pays the seller outside the platform. Payment details are discussed using encrypted messages.</p>
										<p>Once the seller confirms payment, the ETH is released from escrow to the buyer.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- benefits -->
			<section class="benefits">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<h2>Decentralized benefits</h2>
							<div class="decentralized-benefits split-half">
								<div>
									<img src="{{ url('/') }}/assets/image/key.png" width="76" height="46">
									<h3>Control your keys.</h3>
									<p>The escrow account is a decentralized Ethereum smart contract. Rather than trusting a centralized authority to hold your ETH, Crypscrow's escrow system is trust-free.</p>
								</div>
								<div>
									<img src="{{ url('/') }}/assets/image/home.png" width="76" height="46">
									<h3>Control your privacy.</h3>
									<p>Every conversation is protected by a unique secret key which self-destructs after completion. We can only decrypt your messages if the key is volunteered; e.g. during a payment dispute.</p>
								</div>
							</div>
							<div class="split-half wallet">
								<div>
									<h3>Log in with your wallet.</h3>
									<p>Optionally, you can log in without a password by using a compatible Ethereum wallet. Most popular wallets including imToken, MetaMask and Ledger are compatible.</p>
								</div>
								<div class="wallets-vertical-split">
									<div class="list-of-wallets">
										<div>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/MetaMask.svg" alt="MetaMask">
											</a>
											<a class="wallet-img" href="https://token.im/" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/imToken.svg" alt="imToken">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/Cipher.svg" alt="Cipher">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/CoinbaseWallet.svg" alt="Coinbase Wallet">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/GoWallet.svg" alt="GO! Wallet">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/Mist.svg" alt="Mist">
											</a>
										</div>
										<div>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/Ledger.svg" alt="Ledger">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/status.svg" alt="Status">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/TrustWallet.svg" alt="Trust Wallet">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/WalletConnectSoon.svg" alt="WalletConnect (coming soon)">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/tokenPocket.svg" alt="tokenPocket">
											</a>
											<a class="wallet-img" href="#" lang="en">
											<img src="{{ url('/') }}/assets/image/wallet/DappGo.svg" alt="DappGo">
											</a>
										</div>
									</div>
									<p>Tested with these Ethereum wallets.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="payment">
				<div class="container">
					<div class="pay-method">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<a class="button-cta" href="#">Use the platform</a>
							</div>
						</div>
					</div>
				</div>
			</section>
			
			<section>
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="discussion split-half">
								<div>
									<h3>Join the discussion</h3>
									<p>Stay up to date with the latest crypto-news and connect with other traders and staff in our official Telegram groups.</p>
								</div>
								<div class="split-thirds">
									<a class="_2iET telegram" href="#" lang="en">English</a>
									<a class="_2iET telegram" href="#" lang="en">Spanish</a>
									<span class="telegram">CN &amp; RU</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
			@include('footer')