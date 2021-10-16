<!DOCTYPE html>
<html>
	<head>
		<title> Designhost.in </title>
		<style type="text/css">
			@page {
			    size: auto;
			    margin: 0%;
			}
			.para{font-family: arial;text-align: justify; font-size: 13px;}
			li{font-family: arial;text-align: justify; font-size: 13px;}
			th{font-family: arial;text-align: justify; font-size: 13px; text-align: center; border: none; background: #ffe599;}
			td{font-family: arial;text-align: justify; font-size: 13px;}
			span{color: red;}
		</style>
	</head>
	<body>
		<div class="container" style="background:url(<?= base_url('public/front/pdf'); ?>/images/bg-images.jpg); height: 100%; width: 100%; padding: 80px; background-size: cover;">
			<div>
				<p style="width: 50%; float: left;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/logo.png" width="232" height="91" alt="logo">
				</p>
				<p style="width: 50%; float:right; font-size: 16px; text-align: right; font-family: arial;">
					<b><i>DesignHost.in<br/>2151/9A/5, New Patel Nagar,<br/>New Delhi-110008<br/>IVR No -09560768258</i></b>
				</p>
				<!-- <p style="margin-top: 50%; font-size: 28px;">PROMOTIONAL<br>SMS<br>PROPOSAL</p> -->
				<p style="margin-top: 50%; font-size: 28px;"><?= $record['service'] ?></p>
				<p>Date :<span><?= $record['start_date'] ?></span></p>
			</div>
            <div style="width: 100%; float: left;; margin-top: 250px;">
				<div style=" width: 60%; float: left;">
					<p class="para">Created By</p>
					<p class="para"><span>DesignHost.in</span></p>
				</div>
				<div style="width: 40%; float:right;">
					<p class="para">Prepared For</p>
					<p class="para"><span><?= $record['prepare'] ?></span></p>
				</div>
			</div>
		</div>
		<div class="container" style="padding: 70px;">
			<div class="row">
				<h2>Introduction</h2>
				<p class="para" style="width: 60%; float: left;">
					The purpose of this proposal is to give a bit of information about designHost.in and the various services we offer, along with the information and pricing for a custom Promotional SMS Service based on your needs. Based on our previous discussion, I feel like we are a good fit for one another. I’ve spoken with my team, and they are excited to get to work helping you reach your goals.
				</p>
				<p class="para" style="width: 40%; float: right; text-align: center; margin-top: -10px;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/introduction.jpg" width="206" height="158" alt="introduction">
				</p>
			</div>
			<div class="row">
				<p class="para" style="text-align: justify;">
					At the end of this document, you will find a pricing table that includes the services we have discussed previously. If after reviewing out full list of services you feel like the items in the pricing table don’t fit your needs appropriately , feel free to contact I will make the necessary changes.
				</p>
				<p class="para" style="text-align: justify;">
					Once you are happy with the services and prices for your custom Promotional SMS Service solution please go ahead and make necessary payment in out portal and we will move forward from there!
				</p>
			</div>
			<div class="row">
				<h2 style="margin-bottom: 5px;">About Us</h2>
				<p class="para" style="width: 30%; float: left; text-align: center; margin-top: 5px;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/about-us.jpg" width="206" height="158" alt="introduction">
				</p>
				<p class="para" style="width: 70%; float: right;">
					Thanks for being interested in our services. DESIGNHOST.IN is a Delhi based company. DESIGNHOST.IN – A leading Website Design and Domain-Hosting organization. It’s journey began way back in Dec 2012 and has achieved many milestones in this years in the field of Website Design, Web Development, Web Hosting, Google AdWords, Bulk SMS, Bulk Email, Domain Name Registration and other website services using the best available technologies.
				</p>
			</div>
			<?php if($record['service'] == 'Promotional SMS DND'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para">
					Design Host began offers High and Low Priority promotional bulk SMS service within the B2B and B2C segments for instant communications. Within moments, your message is communicated to millions of potential and existing customers, and awareness generated about your products or services. It is an incredible tool with immense power and potential. Within years, Design Host has become the largest B2B and B2C SMS provider in India. Ask our clients, for they have benefited from our experience and terms of service in this field.
				</p>
			</div>
			<div class="row">
				<div class="para">The key features of our services includes</div>
			</div>
			<div class="row">
				<ul class="para" style="width:50%; float: left;">
					<li>Unlimited Validity</li>
					<li>Online panel for monitor and control</li>
					<li>Server time : 9am to 9pm</li>
					<li>Sender id - should be six character (DZNHST)</li>
					<li>SMS Group creation</li>
					<li>Open template.</li>
					<li>Delivery Report of SMS</li>
					<li>Easy to upload excel</li>
					<li>SMS type (Text, Unicode, flash)</li>
				</ul>
				<p class="para" style="width: 50%; float:right; text-align: right;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/bulk.jpg" width="206" height="158" alt="introduction">
				</p>
			</div>
		<?php } else if($record['service'] == 'Call Commitment Proposal' || $record['service'] == 'PPT Design Proposal'){ ?>
			<div class="row"><p style="height: 30%"></p></div>

		<?php } else if($record['service'] == 'Website Design Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para">
					If you intend of raising your online business then one thing is assured that you cannot rule out an importance quality web designing at all. Since, web portal is supposed to be an only way between you and innumerous people who search it and then make up their mind towards availing your services or purchasing the product you are offering, designing work of website must be enticing and appealing. If you are aware to this reality and thus feel that you need to get your website redesigned differently as well as innovatively or yet you do not have any web portal to start your online venture then our Website design company Web point can prove the perfect answer of your requirement. We know very well that how much complete satisfaction of clients is valuable and this is why we are one of the leading companies of market.
				</p>
				<p class="para">
					Our company does not lack efficient and creative employees who are well experienced when it comes to utilize advance technology in performing their tasks. I would certainly let everyone know that since Website design is the field where professionals must be aware to the various developments regarding up gradation of techniques and designing tools among others, our group never remains behind in gaining any fresh information about it. Our creative team is highly equipped with the knowledge of using various tools such as Dreamweaver, illustrator, Photoshop and flash among others professionally. They are truly expert in working on HTML, CSS, JavaScript, etc. So, there is no guess that our employees are thoroughly skilled. Everyone finds our services favorable to him as we never miss of meeting our commitment. We have a work culture of meeting the deadlines 
					since our inception and that definitely proves that why our clients always approach us and we manage of getting more through them. Our services always prove budget friendly for our clients. People with high, medium and low scale of business are our clients as we believe in providing what they seek by charging affordable amount.
				</p>
			</div>
		<?php } else if($record['service'] == 'E-Commerce Webiste Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para" style="width: 70%; float: left; text-align: left;">
					If you are a new business owner thinking of exploiting this vast network of customer base, then you need the right team behind you to bolster your efforts in this sector. Design Host can handle all your queries, understand your service needs, and deliver quality tools promptly so your primary business operations remain unaffected. Our engineers keep abreast with current market trends and can expertly advise you of the same, thereby allowing your decision making process as easy and comfortable as making tea in the morning.
				</p>
				<p class="para" style="width: 30%; float:right; text-align: right;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/bulk.jpg" width="206" height="158" alt="introduction">
				</p>
			</div>
			<div class="row">
				<p class="para">
					Existing shop owners or small business enterprises can directly sell their products online with a bit of help from the Design Host team. This option of selling your products directly online eliminates the middle man, thereby enhancing your profits and reaching a wider audience. It is the right thing to do in today's fast paced and constantly changing environmentBy producing a friendly and attractive ecommerce portal, your task of identifying new customers and satisfying existing ones become extremely time saving and increasingly profitable. We make certain that our concepts and ideas are matched with our client's direct and immediate needs. Our designs and tools are cost effective and can generate maximum value for the money invested. Current economic conditions have stamped out exaggerated and ostentatious designs out of the market. There is place for only approaches that are pragmatic and convenient. Design Host can make that happen, with its budget friendly designs and user friendly tools
				</p>
			</div>

		<?php } else if($record['service'] == 'Email Service Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para">
					Email marketing is still considered to be one of the most valuable and lucrative option in the field of marketing. It is the most employed medium of communication in the world. Nearly 122 billion emails are sent every hour, according to a global report dated April, 2014. With that many emails, one must wonder how often it is that email systems are accessed and used on a daily basis. Through email or through Electronic Data Mailers (EDMs), we can connect with our customers in a personalized manner. It is a most effective tool to build customer loyalty and increase brand awareness. You can send lucrative offers or services as electronic ads to your existing customers as well as new potential customers. It is a highly popular mode of building and maintaining customer base as return on investment can be ascertained and maintained properly. It is next in line to search marketing in the arsenal of marketing tools. It is cheaper, faster, and reliable. A large number of audiences can be targeted properly and easily through this medium. According to research and surveys, companies love email marketing as it has always produced the best value for money results in considerably shorter periods of time.
				</p>
				<p class="para"></p>
			</div>

		<?php } else if($record['service'] == 'Facebook Leads Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para">
					Social marketing is a technique that is used by companies nowadays to reach a wider audience. Since, in today's time your audience is spread all over the world and it becomes important for you to connect with them and keep them updated. Here Design host will come to you rescue. We will tell you how you can increase your social media presence and increase your engagement with your customers. We provide you services for every platform like Facebook, YouTube, Instagram or Twitter. Our team of experts is dedicated towards providing you with the best tricks and techniques according to your needs and preferences. We will tell you when you should post on a social media, what should be posted and how it should be posted. Through social media marketing you can achieve many benefits like- increased brand awareness, more inbound traffic, improved search rankings, better customer satisfaction and improved brand loyalty. We at Designhost will help you in achieving all these benefits. Since, its inception we are synonymous with quality web design and customer satisfaction. Our team will work with you till the last that is till you don't get the desired results. So just give us a chance for your service if you want the best results and services.
				</p>
				<p class="para"></p>
			</div>
		<?php } else if($record['service'] == 'Google Adwords Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para">
					Google Adword is a paid advertising service which helps you in placing search results for your website on a search engine page. Through this service you can easily advertise your product or service on the google page even before your own website has gained traffic. It is one of the simplest and easiest form of advertising and is also easy on the company’s pockets. It is a strong tool that attracts customers who do not have time to surf through the internet related to a particular product.
				</p>
				<p class="para">
					At Designhost we will tell you how to place your advertisement so people not only see it but are also eager to purchase a particular product. Design Host will assist you in achieving the benchmark of your sales figures.
					Results can be tracked easily. Average clicks per day, impression reports, and other marketing analytics are available through us for weekly or monthly review. And it is not just Google Adwords, our domain of expertise in internet marketing envelopes popular websites and search engines such as Yahoo, Bing, Facebook, and LinkedIn. We are here to offer our client's the best services at affordable rates.
				</p>
				<p class="para">
					You can definitely benefit from the Google Adword PPC program as it establishes a reputation for your organization by assigning priority to your products or services when search results are declared for any potential customer.
				</p>
				<p class="para">
					These ads are suitable of mobile promotion also as it will encourage your users to download your apps or take desired action. It is a strong tool to attract customers who do not have time to surf through the internet for a particular product or service. Whenever they need something, they search for it online, and Google is the first website they choose for this purpose. Google has an advantage of presenting our ads upfront for a fee, thereby allowing us to market ourselves using this advantage.

				</p>
			</div>

		<?php } else if($record['service'] == 'Hosting Server Proposal'){ ?>
			<div class="row"><p style="height: 30%"></p></div>

		<?php } else if($record['service'] == 'IVR Service Proposal'){ ?>
			<p class="para">
				Continual servicing of customers and maintaining a customer base is an essential part of successful business operations. For servicing customers regularly and effectively, IVR systems are installed. Interactive Voice Response (IVR) system is an automated system that has the ability to interact with callers in order to gather specific information and to routes calls to the appropriate recipient. It is a virtual-line communication that allows customers to get in touch with you.
			</p>
			<p class="para">
				We not only specialize in online promotion but also provide dynamic solutions via the telephone system. We can install and assign a virtual number system for your organization that is cost-effective and a powerful tool to boost your company's reputation. Presence of IVR systems can bolster a company's image and produce positive impressions on your clients.
			</p>
			<p class="para">
				Furthermore, our virtual phone's diverting system allows you to handle calls from anywhere in the world. Forwarding calls also become simple. We manage systems in a way that allows you to remain connected with your business associates without interruption. Some of salient features include :
			</p>

		<?php } else if($record['service'] == 'Lead Generation Proposal'){ ?>
			<div class="row"><p style="height: 30%"></p></div>
		
		<?php } else if($record['service'] == 'Missed Call Alert Proposal'){ ?>
			<p class="para">
				Success of any business depends on the fact that how consistent or a hassle free communication is held with the customers. Missed call alert service Delhi is one of the shortest routes to reach to customers these days, which is why it has become inevitable part of the industry. One should also make a note of the fact that, benefits of missed call alerts can be enjoyed only after getting associated with the best missed call alert service provider Delhi. Hence it is advisable to keep searching for the best and avail their services. Upon availing such services, customer can be sure of availing benefits as mentioned below.
			</p>
			<p class="para">
				It does not matter if you are beginner or masters in your business, maintaining subscribers are important for your success. Customers are very important for business, and these missed call alerts is an easiest way to stay connected with customers. Some of the benefits which comes along with these alerts are lead generation, coupons delivery and user registration.
			</p>

		<?php } else if($record['service'] == 'Open Cart Proposal'){ ?>
			<div class="row">
				<h2><?= $record['service'] ?></h2>
				<p class="para" style="width: 70%; float: left; text-align: left;">
					If you are a new business owner thinking of exploiting this vast network of customer base, then you need the right team behind you to bolster your efforts in this sector. Design Host can handle all your queries, understand your service needs, and deliver quality tools promptly so your primary business operations remain unaffected. Our engineers keep abreast with current market trends and can expertly advise you of the same, thereby allowing your decision making process as easy and comfortable as making tea in the morning.
				</p>
				<p class="para" style="width: 30%; float:right; text-align: right;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/bulk.jpg" width="206" height="158" alt="introduction">
				</p>
			</div>
			<div class="row">
				<p class="para">
					Existing shop owners or small business enterprises can directly sell their products online with a bit of help from the Design Host team. This option of selling your products directly online eliminates the middle man, thereby enhancing your profits and reaching a wider audience. It is the right thing to do in today's fast paced and constantly changing environment By producing a friendly and attractive ecommerce portal, your task of identifying new customers and satisfying existing ones become extremely time saving and increasingly profitable. We make certain that our concepts and ideas are matched with our client's direct and immediate needs. Our designs and tools are cost effective and can generate maximum value for the money invested. Open Cart Service provide template which can be used directly for you website. New Services cannot be added but only unrequired content can de deleted. Design Host can make that happen, with its budget friendly designs and user friendly tools.
				</p>
			</div>
		<?php } else if($record['service'] == 'Promotional SMS GSM Based'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					Design Host began offers High and Low Priority promotional bulk SMS service within the B2B and B2C segments for instant communications. Within moments, your message is communicated to millions of potential and existing customers, and awareness generated about your products or services. It is an incredible tool with immense power and potential. Within years, Design Host has become the largest B2B and B2C SMS provider in India. Ask our clients, for they have benefited from our experience and terms of service in this field.
				</p>
			</div>
			<div class="row">
				The key features of our services includes
				<ul style="width: 50%; float: left; text-align: left;">
					<li>Unlimited Validity</li>
					<li>Online panel for monitor and control</li>
					<li>Server time :  9am to 9pm</li>
					<li>Sender id - should be six character (DZNHST)</li>
					<li>SMS Group creation</li>
					<li>Open template.</li>
					<li>Delivery Report of SMS</li>
					<li>Easy to upload excel</li>
					<li>SMS type (Text, Unicode, flash)</li>
				</ul>
				<p class="para" style="width: 50%; float:right; text-align: right;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/bulk.jpg" width="306" height="158" alt="introduction">
				</p>
			</div>
		<?php } else if($record['service'] == 'Promotional SMS NON DND Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					Design Host began offers High and Low Priority promotional bulk SMS service within the B2B and B2C segments for instant communications. Within moments, your message is communicated to millions of potential and existing customers, and awareness generated about your products or services. It is an incredible tool with immense power and potential. Within years, Design Host has become the largest B2B and B2C SMS provider in India. Ask our clients, for they have benefited from our experience and terms of service in this field.
				</p>
			</div>
			<div class="row">
				The key features of our services includes
				<ul style="width: 50%; float: left; text-align: left;">
					<li>Unlimited Validity</li>
					<li>Online panel for monitor and control</li>
					<li>Server time :  9am to 9pm</li>
					<li>Sender id - should be six character (DZNHST)</li>
					<li>SMS Group creation</li>
					<li>Open template.</li>
					<li>Delivery Report of SMS</li>
					<li>Easy to upload excel</li>
					<li>SMS type (Text, Unicode, flash)</li>
				</ul>
				<p class="para" style="width: 50%; float:right; text-align: right;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/bulk.jpg" width="306" height="158" alt="introduction">
				</p>
			</div>
		<?php } else if($record['service'] == 'Promotional SMS NON DND Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					At Designhost we will tell you about how you can advertise your website so that it attracts traffic or viewers. Our team will help you in designing a creative website, and then using the right keywords so that it ranks on the top of search engine portals. Through SEO technique you can increase the ranking of your website and also improve your visitors. Our service package includes content marketing, social media management, personal branding and pay-per-click services. These services will be helpful in expanding your business as your engagement with your customers will increase. To stand amongst your competitors you will need to transform your business into a brand to which customers can easily relate. We will help you in this transformation. We do certain on page and off pages activities which includes classifieds, ques and answers in website like Quora, bookmarking , article submission, image sharing , ppt sharing , pdf sharing , profile creation, blog commenting, video sharing . All are activities are high quality work in reputed pages and forums . We also provide reports for the same every 15 days with the progress in rank and the work done regarding your website.
				</p>
				<p class="para">
					We also provide services for managing your social media campaigns for your brand also. Through this you will remain active in the eyes of your customer and it will increase your reach with your customers. So, by hiring us to work you will be assured of receiving the best SEO services as our existing customers say. You will be assured of receiving the best internet marketing services and you don't be disappointed.
				</p>
			</div>
		<?php } else if($record['service'] == 'SEO Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					Search engine optimization is a technique that increases the visitors on your website and helps in increasing the ranking on major search engine portals. Through SEO process you can increase the traffic on your website, and who knows it might lead to increase in sales also.
				</p>
				<p class="para">
					At Designhost we will tell you about how you can advertise your website so that it attracts traffic or viewers. Our team will help you in designing a creative website, and then using the right keywords so that it ranks on the top of search engine portals. Through SEO technique you can increase the ranking of your website and also improve your visitors. Our service package includes content marketing, social media management, personal branding and pay-per-click services. These services will be helpful in expanding your business as your engagement with your customers will increase. To stand amongst your competitors you will need to transform your business into a brand to which customers can easily relate. We will help you in this transformation. We do certain on page and off pages activities which includes classifieds, ques and answers in website like Quora, bookmarking , article submission, image sharing , ppt sharing , pdf sharing , profile creation, blog commenting, video sharing . All are activities are high quality work in reputed pages and forums . We also provide reports for the same every 15 days with the progress in rank and the work done regarding your website.   
				</p>
				<p class="para">
					We also provide services for managing your social media campaigns for your brand also. Through this you will remain active in the eyes of your customer and it will increase your reach with your customers. So, by hiring us to work you will be assured of receiving the best SEO services as our existing customers say. You will be assured of receiving the best internet marketing services and you don't be disappointed.    
				</p>
			</div>
		<?php } else if($record['service'] == 'Toll Free Services Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					For any business to be successful and survive in the market, it is important that they stay connected to their customers and meet their requirements. One of the best ways of staying connected with customers is by opting for IVR or toll free solutions. IVR also known as interactive voice response system is an automated system which is capable of interacting with callers and gather specific information from them. Moreover, the IVR systems are also efficient in routing calls to the appropriate receiver, such that queries of customers can be answered in time and by the correct person.
				</p>
				<p class="para">
					With various service providers available in the market, we rank as one of the best companies. Our services can be opted for online promotion such that dynamic solutions can be achieved with the help of telephonic system. Once you approach for toll free number service Delhi, a specific number is installed and assigned to an organization. This is quite effective in boosting reputation of company and also providing adequate services to company and also to its customers. It should be noted, that IVR systems are quite effective and can be used for creating positive impression on the client.   
				</p>
			</div>
		<?php } else if($record['service'] == 'Transactional SMS Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					Transactional SMS service is used for conveying necessary or vital information to customers regarding a product or service. An example could be messages relating to the purchase of a product from an ecommerce portal, such as time of delivery, invoice amount, order placement details, etc.
				</p>
				<p class="para">
					Registered Companies, Banks & Financial Institution, Insurance Companies, Credit Card Companies, Registered Education Instituted, Airlines & Railway (Ticket & PNR details), are some of the organizations that can send transactional SMS to their customers. Design Host is a prominent member of the SMS Service Provider community in India. We have a virtual presence in all major cities, and therefore, can reach to your customers, be they anywhere in the country. A simple collaboration can connect your messages to countless individuals of the country. We provide SMS/email to OPT-IN subscribers only.
				</p>
				<p class="para">
					Transactional SMS gateway is a template based system, where any business can create any number of message templates from their accounts. Our clients can use our APIs to send transactional messages to their end customers; however, they have to make certain that the correct template is used and additional parameters match.
				</p>
			</div>
		<?php } else if($record['service'] == 'Voice SMS Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					A simple but unique blend of conveying messages through a personalized voice feature is presently considered to be highly popular and an increasingly productive tool. It allows you to communicate with your customers, anywhere in India, in their own language. It effectively jumps over hurdles such as customers with different language, customers' literacy issues or inability to read messages, and even communicating with visually impaired individuals. Creating voice messages are simple and convenient. With our assistance, anybody can do it. Simply contact us and we can assist you in this matter effectively. You can count on our experience and be assured that your messages will be delivered to your customers, clients or employees in the language of their choice. This is an effective tool to reach a much larger market, which includes rural sectors as well, and touch people from all walks of life.
				</p>
				<p class="para">
					Our Voice SMS team is well aware of current TRAI regulations and guidelines and can apprise our clients in times of need. Our clients can thus make an informative decision rather than calculated guesses in terms of what will work and what will not. A knowledgeable team and experienced name is important when you are venturing into the world of technology based marketing. Design Host can clear your doubts and assure you to provide a highly effective medium for corporate communication. You can record your messages from your phone and our team will make sure that it is delivered to your consumers as per your settings and instructions. Or you can convert your text into speech â€“ typed messages will be converted to voice clips. Flexibility is another option that Design host is rather proud of. Once you choose a service, you can alter or redesign your Voice SMS campaigns however way you like in order to maximize your reach and touch potential customers. Pick up your phone and start recording.
				</p>
			</div>
		<?php } else if($record['service'] == 'Whatsapp Marketing Proposal'){ ?>
			<h2><?= $record['service'] ?></h2>
			<div class="row">
				<p class="para">
					Since it first launched, WhatsApp has quickly taken over SMS as the most preferred form of messaging among Indians. WhatsApp currently has 225+ million users in India, which is around half of the total number of internet users in the country.  It a mobile app that’s here to stay in India. The growing number of Indians using WhatsApp can be attributed to the sudden drop in data costs and the introduction of low cost smartphones. Because of this, the app quickly became popular among Indians of all ages and economic backgrounds as it offered a free, simple way to connect with each other. But WhatsApp wasn’t just used for personal conversations among friends and families. For a long time, owners of small businesses like grocery stores and tailors used the app informally to communicate with their customers. Taking notice of this huge potential, WhatsApp marketing is a featurewhich can help brands engage with India’s next billion internet users. This new feature aims to simplify the process for SMEs (Small and Medium Enterprises) to connect with their customers.
				</p>
			</div>
			
		<?php }else {}  ?>



























		</div>

		<?php if($record['service'] == 'Email Service Proposal' || $record['service'] == 'Facebook Leads Proposal' || $record['service'] == 'Promotional SMS GSM Based' || $record['service'] == 'Promotional SMS NON DND Proposal') { ?>
			<br><br><br><br>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		<?php } ?>

		<div class="container" style="padding: 0px 70px 70px 70px;">
			<div class="row">

				<?php if($record['service'] == 'Promotional SMS DND' || $record['service'] == 'IVR Service Proposal' || $record['service'] == 'Missed Call Alert Proposal' || $record['service'] == 'Toll Free Services Proposal' || $record['service'] == 'Transactional SMS Proposal' || $record['service'] == 'Whatsapp Marketing Proposal' || $record['service'] == 'Call Commitment Proposal' || $record['service'] == 'PPT Design Proposal' || $record['service'] == 'Lead Generation Proposal' || $record['service'] == 'Hosting Server Proposal'){ ?>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				<?php } ?>
				<?php if($record['service'] == 'E-Commerce Website Proposal'){ ?>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				<?php } ?>

				<?php if($record['service'] == 'Transactional SMS API'){ ?>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div style="margin-top: 200px;"></div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				<?php } ?>
            
				<?php if($record['service'] == 'Website Design Proposal'){ ?>
					<div style="margin-top: -50px;"></div>
				<?php } ?>
				<h2>Proposal</h2>
				<p class="para" style="width: 60%; float: left;">
					We at Design Host look to provide the best service to our clients at the most costeffective manner. Since, its inception we are synonymous with quality service and customer satisfaction. Our team will work with you till the last that is till you don't get the desired results. So just give us a chance for your service if you want the best results and services.
				</p>
				<p class="para" style="width: 40%; float: right; text-align: center; margin-top: -10px;">
					<img src="<?= base_url('public/front/pdf/'); ?>images/wright.jpg" width="206" height="158" alt="introduction">
				</p>


			</div>

			<div class="row">
				<table border="1" style=" width: 100%;">
					<tr>
						<th style="width: 25%;">Quote #</th>
						<th style="width: 25%;">Subject</th>
						<th style="width: 25%;">Date Created</th>
						<th style="width: 25%;">Valid Until</th>
					</tr>
					<tr>
						<td style="text-align: center; border: none; width: 25%;"><?= $record['quote'] ?></td>
						<td style="text-align: center; border: none; width: 25%;"><?= $record['service'] ?></td>
						<td style="text-align: center; border: none; width: 25%;"><?= $record['start_date'] ?></td>
						<td style="text-align: center; border: none; width: 25%;"><?= $record['end_date'] ?></td>
					</tr>
				</table>
			</div>

			<div class="row">
				<p class="para">Recipient : <span style="color: red;"><?= $record['prepare']; ?></span></p>














				<table border="1" style=" width: 100%;">
					<tr>
						<th style="width: 10%;">Qty</th>
						<th style="width: 45%;">Description</th>
						<th style="width: 15%;">Unit Price</th>
						<th style="width: 15%;">Discount %</th>
						<th style="width: 15%;">Total</th>
					</tr>
					<tr>
						<td style="text-align: center; border: none;width: 10%;">1.</td>
						<td style="text-align: left; border: none;width: 45%;">
						<?php if(($record['service'] == 'Website Design Proposal') || $record['service'] == 'Facebook Leads Proposal' || $record['service'] == 'Google Adwords Proposal' || $record['service'] == 'IVR Service Proposal' || $record['service'] == 'Open Cart Proposal' || $record['service'] == 'PPT Design Proposal' || $record['service'] == 'Toll Free Services Proposal' || $record['service'] == 'Lead Generation Proposal' || $record['service'] == 'Missed Call Alert Proposal'){ 
							?>
							<?= $record['service']; ?>

						<?php } else if($record['service'] == 'E-Commerce Website Proposal') { ?>
							<?= $record['service']; ?>

						<?php } else if($record['service'] == 'SEO Proposal') { ?>
							<?= $record['service']; ?>
							<?= $record['keyword']; ?> Keywords

						<?php } else if($record['service'] == 'Hosting Server Proposal') { ?>
							<?= $record['service']; ?>For 1 Year

						<?php } else if($record['service'] == 'Email Service Proposal') { ?>
							<?= $record['service']; ?> 
							(<?= $record['volume']; ?> Email * <?= number_format($record['price'], 3); ?> / Email)

						<?php } else { ?>
							<?= $record['service']; ?> (<?= $record['volume']; ?> SMS *<?= number_format($record['price'], 3); ?>/SMS)
						<?php } ?>
						</td>
						<td style="text-align: center; border: none;width: 15%;"><?= number_format($record['unit_price'], 2); ?></td>
						<td style="text-align: center; border: none;width: 15%;">0.00</td>
						<td style="text-align: center; border: none;width: 15%;">Rs <?= number_format($record['total'], 2); ?></td>
					</tr>




























					<tr>
						<td style="text-align: center; border: none;"></td>
						<td style="text-align: left; border: none;">
						<?php if($record['service'] == 'Promotional SMS DND'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
								<li>Delivered on All Numbers</li>
								<li>160 character Allowed in 1 SMS count</li>
								<li>Multiple sender id</li>
								<li>Excel Upload – Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 10 to 6 PM</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – DZNHST</li>
								
							</ul><br><br><br><br><br><br>
							
						<?php } else if($record['service'] == 'Call Commitment Proposal'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
								<li>Campaign Activity via SMS</li>
								<li>Call via IVR</li>
								<li>Fake Call Replacement.</li>
								<li>Above 2 mints  Calls Count</li>
								<li>Above 45 Sec Miscall Count</li>
								<li>Quality based Lead</li>
							</ul><br><br><br><br><br><br>

						<?php } else if($record['service'] == 'E-Commerce Website Proposal'){ ?>
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Website Design Proposal' || $record['service'] == 'PPT Design Proposal'){ ?>
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Email Service Proposal'){ ?>
							Features Of Panel
							<ul style="margin: 30px; list-style-type:circle;">
								<li>Online panel</li>
								<li>100 % Delivery</li>
								<li>Delivery Report</li>
								<li>Validity – Unlimited<br>
								1 Mailer @1500 Rs</li>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Facebook Leads Proposal'){ ?>
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Google Adwords Proposal'){ ?>
							Features Of Service
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Hosting Server Proposal'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								<li>1 Domain Limit to Host</li>
								<li>C Panel</li>
								<li>100 Email id Creation Permission on per domain</li>
								<li>Validity For 1 year</li>
								<li>Window Hosting on Shared Server</li>
								<li>5 GB Bandwitch</li>
								<li>Unlimited Space</li>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'IVR Service Proposal'){ ?>
							Features Of Service
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Lead Generation Proposal'){ ?>
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
					           	<!-- <li>Call via IVR</li>
					           	<li>Fake Call Replacement</li>
				           		<li>Above 45 Sec miscall Count</li>
					           	<li>Campaign Source SMS</li>
					           	<li>Out of budget not count</li> -->

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Missed Call Alert Proposal'){ ?>
							<ul style="margin: 30px;">
								Features of panel
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
								<!-- <li>Online Web Panel ( 2 Panel for  miscall Service)</li>
								<li>Two Virtual Numbers</li>
								<li>Unlimited Misscall</li>
								<li>Sms Alert on call</li>
								<li>Activation Time 0-24hrs</li>
								<li>1 year Validity  for each Virtual number</li> -->

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Open Cart Proposal'){ ?>
							<ul style="margin: 30px;">
								Features
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Promotional SMS GSM Based'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
         						<li>Delivered on Non Numbers</li>
								<li>160 character Allowed in 1 SMS.</li>
								<li>Excel Upload – Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 10 AM To 6 PM</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – 9999999999</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Promotional SMS NON DND Proposal'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
					         	<li>Delivered on Non Numbers</li>
								<li>160 character Allowed in 1 SMS.</li>
								<li>Excel Upload – Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 10 AM To 6 PM</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – DZNHST</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Promotional SMS Proposal'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
					         	<li>Delivered on All Numbers</li>
								<li>160 character Allowed in 1 SMS count</li>
								<li>Multiple sender id </li>
								<li>Excel Upload – Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 9 AM to 9 PM</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – DZNHST</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'SEO Proposal'){ ?>
							<ul style="margin: 30px;">
								<?php if(!empty($record['project_details'])){ ?>
									<?= $record['project_details'] ?>
								<?php } ?>
								<!-- On Page & Off Page SEO
								<li>12 Keywords</li>
								<li>Report every 15 days</li>
								<li>Advance Payment Every Month</li>
								<li>Targeted Number of Key Phrases</li>
								<li>Website & Competitor Analysis</li>
								<li>Keyword Research & Analysis</li>
								<li>Make SEO Friendly URL Structure</li>
								<li>Sitemap Submit in Google Webmaster Tool</li>
								<li>Google Analytics Install</li>
								<li>Content writing @500 Rs monthly</li> -->

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Toll Free Services Proposal'){ ?>
							<ul style="margin: 30px;">
								Features Of Panel
								<?= $record['project_details'] ?>
								<!-- <li>12 Month Validity</li>
								<li>Web Panel</li>
								<li>Welcome Tune</li>
								<li>Series -1800200****</li>
								<li>Unlimited Agent</li>
								<li>12000 Free Minutes</li>
								<li>Activation Time 12 hours</li>
								<li>Excel Export</li> -->

							</ul><br><br><br><br><br><br>

						<?php }else if($record['service'] == 'Transactional SMS Proposal'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
								<li>Delivered on all numbers</li>
								<li>Excel Upload – Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 24*7</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – 6 Characters Alpha(DZNHST)</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Transactional SMS API'){ ?>
							<ul style="margin: 30px; list-style-type:circle;">
								Features Of Panel
								<li>Delivered on all numbers</li>
								<li>Excel Upload - Quick</li>
								<li>Validity – Unlimited</li>
								<li>Delivery instant</li>
								<li>Schedule based Available</li>
								<li>Delivery Ratio 100%</li>
								<li>Server Time 24*7</li>
								<li>HTTP API</li>
								<li>Report Will generate between 0 to 24 hrs</li>
								<li>Sender ID – 6 Characters Alpha(DZNHST)</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Voice SMS Proposal'){ ?>
							Feature of panel
							<ul style="margin: 30px; list-style-type:circle;">
								<li>Excel Upload - Quick</li>
								<li>Validity unlimited</li>
								<li>Delivered 10 AM to 6 PM</li>
								<li>Server Time 9 AM To 9 AM</li>
								<li>Report Will generate between 0 to 4 hrs</li>
								<li>Pulse 30 seconds</li>
								<li>Delivered all number</li>
								<li>Answered  calls counted</li>

							</ul><br><br><br><br><br><br>
						<?php }else if($record['service'] == 'Whatsapp Marketing Proposal'){ ?>
							Feature of panel
							<ul style="margin: 30px; list-style-type:circle;">
								<li>Online Web Panel</li>
								<li>Unlimited validity</li>
								<li>Activation Time 0-24hrs</li>
								<li>Answered Based</li>
								<li>Non WhatsApp Refundable</li>
								<li>Server Time 10 AM To 6 PM</li>
								<li>Report 0-24 hours</li>
								<li>Image, Text, Video can Send</li>
							</ul><br><br><br><br><br><br>
						<?php } else {} ?>
























						</td>
						<td style="text-align: center; border: none;"></td>
						<td style="text-align: center; border: none;"></td>
						<td style="text-align: center; border: none;"></td>
					</tr>
					<tr style="background: #ffe599; height: 20px;">
						<td style="text-align: center; border: none;width: 10%;"></td>
						<td style="text-align: left; border: none;width: 35%;"></td>
						<td style="text-align: center; border: none;width: 15%;"></td>
						<td style="text-align: left; border: none;width: 25%;">
							<p>Sub Total<br/>I GST @ 18.00%<br><b>Total</b></p>
						</td>
						<td style="text-align: left; border: none;width: 15%;">
							<p>Rs <?= number_format($record['total'], 2); ?><br/>
								<?php if($record['gst'] == 1){ ?>
								Rs <?= number_format($record['total']*18/100, 2); ?><br>
							<?php }else{ ?>
								Rs 0.00<br>
							<?php } ?>
								<b>Rs <?= number_format($record['total_amount'], 2); ?></b>
							</p>
						</td>
					</tr>
				</table>
			</div>
			<div class="row">
				<p class="para"><i><b>Payments Terms</b></i></p>
				<?php if($record['service'] == 'Website Design Proposal' || $record['service'] == 'E-Commerce Website Proposal' || $record['service'] == 'Open Cart Proposal'){ ?>
					<p class="para">The payment terms shall be <b>50 % of the entire amount must be paid in advance and the remaining 50 % shall be paid only after completion of the project.</b></p>
					<p class="para"><b><i>Time Frame</i></b></p>
					<p class="para">
						The estimated time frame of the project shall be <?php if($record['service'] == 'E-Commerce Website Proposal'){ echo "1 month"; }else{ echo "7 to 10 days";} ?> working days after the requirement are provided & After Theme Approved. This is subjective to the requirements and may vary.
					</p>
					<p class="para">
						Project will be valid for 2 Month From the Date of Theme Approved. Till 2 Month if customer will not respond Project will be Cancelled & Non-Refundable. 
					</p>
					<p class="para"><i><b>Terms & Conditions</b></i></p>
					<p class="para">
						<ul>
							<li>
								DesignHost.in will build a website for <b><?= $record['prepare'] ?></b> according to the description laid out in this proposal. Any additional features, pages, or other changes to project requirements may affect the timeline and costs laid out in the tables above, and will require a separate change order document.
							</li>
							<li>
								As per company policy, if the website is not completed within a maximum time of 2 months from the date of theme approval due to requirement and data not provided from the client’s end after repeated reminders, the project shall be closed and DesignHost holds no liability towards the same.
							</li>
						</ul>
					</p>
				<?php } else { ?>
					<p class="para">The payment terms shall be 100% of the entire amount must be paid in advance.</p>
				
					<p class="para"><i><b>Terms & Conditions</b></i></p>
					<p class="para">
						DesignHost.in will provide service for you according to the description laid out in this proposal. Any additional features, pages, or other changes to project requirements may affect the timeline and costs laid out in the tables above, and will require a separate change order document.
					</p>
				<?php } ?>
			</div>
		</div>
		
	</body>
</html>