const { Component, RawHTML, useState, useEffect } = wp.element;
import { columns, postComments, store, styles } from "@wordpress/icons";

import PGSupportTicket from "../../components/support-ticket";
import PGtab from "../../components/tab";
import PGtabs from "../../components/tabs";
import { pricingData } from "./pricingData";
import PricingTable from "./PricingTable";
import { reviews } from "./reviews";
var myStore = wp.data.select("postgrid-shop");

function Html(props) {
	if (!props.warn) {
		return null;
	}

	var [postData, setpostData] = useState(props.postData); // Using the hook.
	var addNotifications = props.addNotifications;
	var customerData = props.customerData;
	var appData = props.appData;

	const freeVsProArgs = [
		{
			feature: "View Type - Team Grid",
			free: true,
			pro: true,
		},
		{
			feature: "View Type - Team Slider",
			free: true,
			pro: true,
		},
		{
			feature: "View Type - Team Masonry",
			free: false,
			pro: true,
		},
		{
			feature: "Preloader - Hide team until page load",
			free: true,
			pro: true,
		},

		// {
		// 	feature: "Schema",
		// 	isHeading: true,
		// },
		// {
		// 	feature: "Enable/Disable Schema ",
		// 	free: true,
		// 	pro: true,
		// },


		{
			feature: "Edit content with WYSIWYG editor",
			free: true,
			pro: true,
		},
		{
			feature: "Item Source",
			isHeading: true,
		},
		{
			feature: "Item Source - Manual",
			free: true,
			pro: true,
		},

		{
			feature: "Generate items by AI",
			free: false,
			pro: true,
			new: true,
			hot: true,
		},
		{
			feature: "Item Source - Posts",
			free: false,
			pro: true,
			new: true,
		},
		{
			feature: "Layout Editor",
			isHeading: true,
		},
		{
			feature: "Tree View",
			free: true,
			pro: true,
		},
		{
			feature: "Live Preview",
			free: true,
			pro: true,
		},
		{
			feature: "Advanced Style Component",
			free: true,
			pro: true,
		},
		{
			feature: "Copy-Paste Layout",
			free: true,
			pro: true,
		},
		{
			feature: "Duplicate Elements",
			free: true,
			pro: true,
		},
		{
			feature: "Remove All Elements",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Title",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Content",
			free: true,
			pro: true,
		},

		{
			feature: "Element - Ratting",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Person Name",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Person Job Title",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Person Avatar",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Company Name",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Company Website",
			free: false,
			pro: true,
		},
		{
			feature: "Element - Company Logo",
			free: true,
			pro: true,
		},
		{
			feature: "Element - Date",
			free: false,
			pro: true,
		},
		{
			feature: "Element - Custom Text",
			free: false,
			pro: true,
		},
		{
			feature: "Element - Container",
			free: true,
			pro: true,
		},







	];

	const ourPlugins = [
		{
			name: "Plugin Name 1",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
		{
			name: "Plugin Name 2",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
		{
			name: "Plugin Name 3",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
		{
			name: "Plugin Name 4",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
		{
			name: "Plugin Name 5",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
		{
			name: "Plugin Name 6",
			description:
				"At ShapedPlugin LLC, we have been looking for the best way to create FAQ pages or sections on WordPress sites.",
			logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/512px-WordPress_blue_logo.svg.png",
			link: "https://example.com",
		},
	];

	const copyData = (data) => {
		navigator.clipboard
			.writeText(data)
			.then(() => {
				addNotifications({
					title: "Coupon Code Copied!",
					content: "Please use coupon code on checkout page.",
					type: "success",
				});
			})
			.catch((err) => { });
	};

	return (
		<div className="ml-5">
			<div className="flex justify-between items-center p-5 pb-20 bg-white ">
				<div>
					<div className="flex justify-between items-center gap-3">
						<span className="text-4xl font-extrabold">{appData.name}</span>{" "}
						<span className="text-base">By PickPlugins</span>
					</div>


					<div className="my-3 flex items-center gap-3">
						{/* <div className="font-mono text-sm">Version: 2.3.5</div> */}
						<a
							className=" "
							href={appData.demoUrl}
							target="_blank">
							Live Demo
						</a>

					</div>
				</div>
				<div className="">




					<div className="my-4 max-w-52">
						Help us by providing your feedbacks and five star reviews on
						wordpress.org 🌟🌟🌟🌟🌟
					</div>
					<a
						className=" bg-amber-500 text-white no-underline font-medium px-[16px] py-[8px]  hover:bg-amber-700 hover:text-white rounded-md w-max transition-colors duration-300"
						href={appData.reviewsUrl}
						target="_blank">
						Submit Reviews
					</a>
				</div>
			</div>

			<PGtabs
				activeTab="overview"
				orientation=""
				tabsWrapperClass="mt-[-50px] "
				contentClass=" w-full"
				navItemsWrapClass="gap-3 px-10"
				navItemClass=" px-5 py-3 gap-2 rounded-t-md"
				navItemSelectedClass="!bg-white border-2  border-b-0 border-solid  border-blue-700"
				activeClass="active-tab"
				onSelect={(tabName) => { }}
				tabs={[
					{
						name: "overview",
						title: "Overview",
						icon: columns,
						className: "tab-disable-blocks",
					},
					{
						name: "edit",
						title: "Free Vs Pro",
						icon: styles,
						className: "tab-disable-blocks",
					},
					// {
					// 	name: "templates",
					// 	title: "About Us",
					// 	icon: postAuthor,
					// 	className: "tab-disable-blocks",
					// },
					{
						name: "buyNow",
						title: "Buy Now",
						icon: store,
						className: "tab-disable-blocks",
					},

					{
						name: "supportTicket",
						title: "Send Feedbacks",
						icon: postComments,
						className: "tab-disable-blocks",
					},
				]}>
				<PGtab name="overview">
					<div className="flex gap-4 items-start flex-wrap mt-10 px-10">
						<div className="flex-1 flex flex-col gap-3 p-[40px] max-w-[70%] bg-white rounded-md shadow-md">
							<h2 className="text-[32px] font-semibold text-gray-800">
								Super Excited to See you!
							</h2>
							<p className="text-gray-500 text-[14px]">
								Thanks for installing Team plugin! Watch this video to get
								started.
							</p>
							<iframe
								width="100%"
								height="400"
								src=""
								title="YouTube video player"
								className="rounded-md overflow-hidden"
								frameborder="0"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
								referrerpolicy="strict-origin-when-cross-origin"
								allowfullscreen></iframe>
						</div>
						<div className="grid md:grid-cols-1 grid-cols-3 content-between md:max-w-[30%] max-w-full gap-3 text-gray-800">
							<div className="flex flex-col gap-3 bg-white p-[20px] rounded-md shadow-md">
								<div className="text-[18px] font-semibold flex items-center gap-2">
									<span>🌟</span>Videos
								</div>
								<p>
									Watch our videos to see how the team works in real-world
									projects!
								</p>
								<a
									target="_blank"
									href=""
									className="inline-block no-underline font-medium px-[16px] py-[8px] border border-solid border-gray-700 text-gray-700 hover:bg-gray-700 hover:text-white rounded-md w-max transition-colors duration-300">
									Watch on YouTube
								</a>
							</div>
							<div className="flex flex-col gap-3 bg-white p-[20px] rounded-md shadow-md">
								<div className="text-[18px] font-semibold flex items-center gap-2">
									<span>🌟</span>Documentation
								</div>
								<p>
									Check out our detailed documentation to learn what the
									Team plugin can do!
								</p>
								<a
									target="_blank"
									href="#"
									className="inline-block no-underline font-medium px-[16px] py-[8px] border border-solid border-gray-700 text-gray-700 hover:bg-gray-700 hover:text-white rounded-md w-max transition-colors duration-300">
									Check Documentation
								</a>
							</div>
							<div className="flex flex-col gap-3 bg-white p-[20px] rounded-md shadow-md">
								<div className="text-[18px] font-semibold flex items-center gap-2">
									<span>🌟</span>Need Help?
								</div>
								<p>
									Contact our friendly support team for quick and personalized
									help!
								</p>
								<a
									target="_blank"
									href="https://pickplugins.com/create-support-ticket/"
									className="inline-block no-underline font-medium px-[16px] py-[8px] border border-solid border-gray-700 text-gray-700 hover:bg-gray-700 hover:text-white rounded-md w-max transition-colors duration-300">
									Create Support Ticket
								</a>
							</div>
						</div>
					</div>
				</PGtab>
				<PGtab name="edit">
					<div className=" rounded-md   mt-10 px-10">
						<table className="table-auto w-full text-left">
							<thead className="bg-gray-700 text-white">
								<tr className="">
									<th className="min-w-[550px] py-4 px-8">FEATURES</th>
									<th className="min-w-[100px] py-4 px-8 text-center">Free</th>
									<th className="min-w-[100px] py-4 px-8 text-center">👑PRO</th>
								</tr>
							</thead>
							<tbody className="bg-gray-100 text-gray-800">
								{freeVsProArgs.map((item, index) => (
									<>
										{item.isHeading && (
											<tr
												key={index}
												className="bg-gray-400 last:rounded-b-md last:overflow-hidden">
												<td className="py-3 px-8" colSpan={"3"}>
													<div className="flex gap-2 items-center ">
														{item.feature && (
															<span className="text-base">{item.feature}</span>
														)}

														{item.new && (
															<span className="text-emerald-100 inline-block text-[12px] leading-none px-2 py-1 bg-emerald-500 rounded-full">
																NEW
															</span>
														)}
														{item.hot && (
															<span className="text-red-100 inline-block text-[12px] leading-none px-2 py-1 bg-orange-400 rounded-full">
																HOT
															</span>
														)}
													</div>
												</td>
											</tr>
										)}
										{!item?.isHeading && (
											<tr
												key={index}
												className="even:bg-gray-200 last:rounded-b-md last:overflow-hidden">
												<td className="py-3 px-8">
													<div className="flex gap-2 items-center">
														{item.feature && <span>{item.feature}</span>}

														{item.new && (
															<span className="text-emerald-100 inline-block text-[12px] leading-none px-2 py-1 bg-emerald-500 rounded-full">
																NEW
															</span>
														)}
														{item.hot && (
															<span className="text-red-100 inline-block text-[12px] leading-none px-2 py-1 bg-orange-400 rounded-full">
																HOT
															</span>
														)}
													</div>
												</td>
												<td className="py-3 px-8  text-center">
													{item.free && <span>✔️</span>}
													{!item.free && <span>❌</span>}
												</td>
												<td className="py-3 px-8 text-center">
													{item.pro && <span>✔️</span>}
													{!item.pro && <span>❌</span>}
												</td>
											</tr>
										)}
									</>
								))}
							</tbody>
						</table>
					</div>
				</PGtab>
				<PGtab name="templates">
					<div className="grid grid-cols-2 gap-4 w-full p-7 bg-white mt-10">
						<div className="self-center">
							<figure>
								<img
									src="https://images.pexels.com/photos/1595385/pexels-photo-1595385.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
									alt=""
									className="w-full rounded-lg shadow-sm object-contain"
								/>
								<figcaption className="text-sm text-center mt-2">
									ShapedPlugin Team
								</figcaption>
							</figure>
						</div>
					</div>
					<div>
						<h3 className="text-2xl font-medium my-8">
							Improve your website with our top-notch plugins!
						</h3>
						<div className="grid grid-cols-3 gap-4">
							{ourPlugins.map((plugin) => (
								<div className="bg-gray-200 hover:bg-gray-300 shadow-sm p-8 rounded-lg relative">
									<h4 className="font-medium text-lg mb-4">{plugin.name}</h4>
									<p className="text-[14px]">{plugin.description}</p>
									<a
										target="_blank"
										href={plugin.link}
										className="absolute inset-0 "></a>
								</div>
							))}
						</div>
					</div>
				</PGtab>
				<PGtab name="supportTicket">
					<div className=" mx-10 p-5 my-10 bg-white rounded-sm">
						<PGSupportTicket />
					</div>
				</PGtab>
				<PGtab name="buyNow">
					{customerData.isPro && (
						<div className="mx-10 p-5 my-10  rounded-sm text-center bg-orange-200">
							<h3 className="text-2xl ">
								You already purchased, Want to Buy Again!
							</h3>
						</div>
					)}

					<div className="flex items-center justify-between mx-10 p-5 my-10 bg-white rounded-sm">
						<div>
							<h3 className="text-2xl ">Unlock Pro Features</h3>
							<p className="text-base">
								Get 25% off today by using our exclusive coupon code!
							</p>
						</div>
						<div>
							<div
								className="p-2 px-4 border-2 border-blue-600 border-dashed cursor-pointer text-xl"
								onClick={() => {
									var str = `BUILDER25`;

									copyData(str);
								}}>
								BUILDER25
							</div>
							<div className="text-center p-3">Click To Copy</div>
						</div>
					</div>

					<PGtabs
						activeTab="yearly"
						orientation=""
						tabsWrapperClass="mt-[50px] "
						contentClass=" w-full"
						navItemsWrapClass="gap-3 px-10 justify-center"
						navItemClass=" px-5 py-3 gap-2 rounded-md"
						navItemSelectedClass="!bg-white border-2  border-solid  border-blue-700"
						activeClass="active-tab"
						onSelect={(tabName) => { }}
						tabs={[
							{
								name: "yearly",
								title: "Yearly",
								icon: columns,
								className: "tab-yearly",
							},
							{
								name: "lifetime",
								title: "Lifetime",
								icon: styles,
								className: "tab-lifetime",
							},
							// {
							// 	name: "freeTrail",
							// 	title: "Free Trail",
							// 	icon: columns,
							// 	className: "tab-yearly",
							// },
						]}>
						<PGtab name="yearly">
							<div className="grid grid-cols-3 gap-6 mt-10 px-10">
								{pricingData.yearly.map((item, i) => (
									<PricingTable key={i} data={item} />
								))}
							</div>
						</PGtab>
						<PGtab name="lifetime">
							<div className="grid grid-cols-3 gap-6 mt-10 px-10">
								{pricingData.lifetime.map((item, i) => (
									<PricingTable key={i} data={item} />
								))}
							</div>
						</PGtab>
						<PGtab name="freeTrail">freeTrail</PGtab>
					</PGtabs>

					<div className="flex items-center justify-between mx-10 p-5 my-10 bg-white rounded-sm">
						<div>
							<h3 className="text-2xl ">
								Enjoy a 14-Day Money-Back Guarantee—No Questions Asked!
							</h3>
							<p className="text-base">
								We are committed to ensuring 100% satisfaction with our plugin
								and support. If, for any reason, our plugin doesn't meet your
								expectations, simply let us know. We'll provide a full refund
								within 14 days of your purchase—no questions asked. Learn more
								in our refund policy.
							</p>
						</div>
						<div>
							<div className="p-2 px-4 ">
								<svg
									width="212"
									height="28"
									viewBox="0 0 212 28"
									fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M42.5847 13.8542H48.8882C48.4685 12.2528 47.3185 11.6035 45.9179 11.6035C44.3778 11.6035 43.1437 12.4429 42.5847 13.8542M52.5864 16.5927H42.3611C42.7808 18.6553 44.517 19.4153 46.0296 19.4153C47.9346 19.4153 48.749 18.2756 48.749 18.2756H52.2783C51.213 20.9877 48.6646 22.4787 45.9179 22.4787C42.1353 22.4787 38.8297 19.6848 38.8297 15.4551C38.8297 11.25 42.1078 8.646 45.8059 8.646C49.3924 8.646 53.0358 11.0598 52.5864 16.5927"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M87.3226 15.5633C87.3226 13.4474 86.0337 11.7932 83.905 11.7932C81.7745 11.7932 80.346 13.4474 80.346 15.5633C80.346 17.6792 81.7745 19.3333 83.905 19.3333C86.0337 19.3333 87.3226 17.6792 87.3226 15.5633M76.6754 15.5896C76.6754 11.25 80.1499 8.646 83.905 8.646C87.6876 8.646 90.9932 11.2764 90.9932 15.5345C90.9932 19.848 87.5735 22.4784 83.7912 22.4784C79.9811 22.4784 76.6754 19.848 76.6754 15.5896"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M105.991 14.9937V22.3439H102.263V15.8064C102.263 15.3449 102.601 11.9279 99.9113 11.7935C98.5927 11.7117 96.2403 12.416 96.2403 15.9699V22.3439H92.5425V8.78076H95.9372L95.9482 10.6636C95.9482 10.6636 97.4788 8.646 100.333 8.646C103.947 8.646 105.991 11.25 105.991 14.9937"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M119.618 11.5216C118.441 11.5216 117.936 12.0914 117.936 12.6613C117.936 13.5824 119.198 13.854 120.038 14.0175C122.533 14.5319 125.054 15.2653 125.054 18.1385C125.054 20.9326 122.673 22.4787 119.787 22.4787C116.565 22.4787 114.072 20.5814 113.903 17.7058H117.348C117.432 18.5185 117.993 19.5764 119.702 19.5764C121.13 19.5764 121.468 18.8455 121.468 18.2756C121.468 17.2707 120.487 16.9724 119.533 16.7559C117.882 16.4026 114.323 15.7534 114.323 12.6613C114.323 10.0022 116.958 8.646 119.675 8.646C122.812 8.646 124.885 10.4903 125.054 12.7694H121.607C121.495 12.3079 121.048 11.5216 119.618 11.5216"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M136.381 15.5633C136.381 13.3106 135.12 11.9831 133.299 11.9831C131.59 11.9831 129.879 13.1758 129.879 15.5633C129.879 17.9487 131.59 19.1435 133.299 19.1435C135.12 19.1435 136.381 17.814 136.381 15.5633V15.5633ZM139.883 8.78076V27.7681H136.381V21.0141C135.485 21.9903 134.223 22.4784 132.765 22.4784C129.209 22.4784 126.238 19.6582 126.238 15.5632C126.238 11.4662 129.209 8.646 132.765 8.646C135.561 8.646 136.608 10.4625 136.608 10.4625L136.603 8.78076H139.883Z"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M159.905 13.8542H166.208C165.788 12.2528 164.638 11.6035 163.238 11.6035C161.698 11.6035 160.464 12.4429 159.905 13.8542M169.906 16.5927H159.679C160.101 18.6553 161.837 19.4153 163.349 19.4153C165.254 19.4153 166.069 18.2756 166.069 18.2756H169.598C168.533 20.9877 165.984 22.4787 163.238 22.4787C159.455 22.4787 156.15 19.6848 156.15 15.4551C156.15 11.25 159.428 8.646 163.126 8.646C166.712 8.646 170.356 11.0598 169.906 16.5927"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M174.791 13.8542H181.094C180.674 12.2528 179.524 11.6035 178.124 11.6035C176.584 11.6035 175.35 12.4429 174.791 13.8542M184.792 16.5927H174.567C174.987 18.6553 176.723 19.4153 178.235 19.4153C180.141 19.4153 180.955 18.2756 180.955 18.2756H184.484C183.419 20.9877 180.87 22.4787 178.124 22.4787C174.341 22.4787 171.036 19.6848 171.036 15.4551C171.036 11.25 174.314 8.646 178.012 8.646C181.598 8.646 185.242 11.0598 184.792 16.5927"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M197.267 19.3069V22.3436H185.36V20.5527L192.113 11.8198H185.641V8.78076H196.988V10.5717L190.235 19.3069H197.267Z"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M211.845 8.78076V20.7161V20.9877C211.845 24.6497 209.91 27.9053 205.119 27.9053C200.636 27.9053 198.2 25.056 198.2 22.9138H201.702C201.702 22.9138 202.233 24.7314 205.007 24.7314C207.362 24.7314 208.343 23.4282 208.343 21.5309V20.9611C207.724 21.6393 206.55 22.4787 204.448 22.4787C200.778 22.4787 198.48 19.9034 198.48 16.1331L198.451 8.78076H202.094V15.3183C202.094 17.1623 202.767 19.3336 205.092 19.3336C206.296 19.3336 208.286 18.7637 208.286 15.1548V8.78076H211.845Z"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M36.1626 18.2723C36.1626 19.1181 36.4958 19.467 37.1141 19.467C37.5497 19.467 37.8327 19.4164 38.2454 19.2926L38.4761 22.0799C37.7048 22.3272 36.959 22.4774 36.0075 22.4774C33.8244 22.4774 32.4874 21.7817 32.4874 18.7693V3.35645H36.1626V18.2723Z"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M75.0944 14.9937V22.3439H71.3665V15.8064C71.3665 13.9357 71.563 11.5749 68.9848 11.7935C68.3142 11.8465 66.4639 12.1444 66.4639 15.9699V22.3439H62.7658V15.8064C62.7658 13.9357 62.9619 11.5749 60.3841 11.7935C59.711 11.8465 57.8632 12.1444 57.8632 15.9699V22.3439H54.165V8.78075H57.56L57.5631 10.6636C57.5631 10.6636 58.8605 8.64599 61.2805 8.64599C64.1966 8.64599 65.3412 10.8424 65.3412 10.8424C65.3412 10.8424 66.5967 8.61963 69.7992 8.61963C73.4405 8.61963 75.0944 11.2236 75.0944 14.9937"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M141.455 16.131V8.78076H145.183V15.3183C145.183 15.7797 144.845 19.1967 147.535 19.3312C148.853 19.413 151.205 18.7086 151.205 15.1548V8.78076H154.904V22.3439H151.513L151.498 20.4611C151.498 20.4611 149.967 22.4787 147.113 22.4787C143.499 22.4787 141.455 19.8747 141.455 16.131"
										fill="#121217"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M6.92836 17.1856L14.4397 20.6583C15.3706 21.0889 16.0278 21.8116 16.3827 22.6406C17.2803 24.7399 16.0535 26.8869 14.1276 27.6591C12.2015 28.4309 10.1486 27.9342 9.21523 25.7511L5.94631 18.0866C5.693 17.4925 6.32934 16.9087 6.92836 17.1856"
										fill="#FFC233"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M7.37953 14.9376L15.1332 12.0066C17.71 11.0325 20.525 12.8756 20.487 15.5536C20.4864 15.5886 20.4858 15.6235 20.4849 15.6588C20.4292 18.2666 17.6926 20.0194 15.1723 19.0968L7.38688 16.2473C6.76583 16.0201 6.76124 15.1713 7.37953 14.9376"
										fill="#FFC233"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M6.9449 13.9224L14.567 10.6837C17.0998 9.60736 17.7426 6.37695 15.7589 4.51043C15.7329 4.48585 15.7069 4.46156 15.6806 4.43728C13.7357 2.63207 10.5207 3.26767 9.41349 5.64539L5.99314 12.9915C5.72024 13.5773 6.33701 14.1806 6.9449 13.9224"
										fill="#FFC233"
									/>
									<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M4.98349 12.6426L7.75465 5.04415C8.09822 4.102 8.03458 3.1412 7.67939 2.3122C6.77994 0.21378 4.34409 -0.463579 2.41853 0.309741C0.493284 1.08336 -0.594621 2.84029 0.340622 5.02253L3.63095 12.6787C3.8861 13.272 4.76261 13.2486 4.98349 12.6426"
										fill="#FFC233"
									/>
								</svg>
							</div>
							<div className="text-center p-3">
								Secure Payment by{" "}
								<span className="font-bold">Lemon Squeezy</span>
							</div>
						</div>
					</div>

					<div className="grid grid-cols-3 gap-5 mx-10">
						{reviews.map((item, i) => (
							<div key={i} className=" flex flex-col text-center">
								<p className="bg-white shadow-lg rounded-lg p-6 text-left text-gray-600">
									{item.comment}
								</p>
								<div className="flex items-center gap-6">
									<img
										src={item.profileImage}
										alt={`${name}'s profile`}
										className="w-12 h-12 rounded-full border border-gray-300"
									/>
									<div>
										{" "}
										<a
											href={item.profileLink}
											target="_blank"
											rel="noopener noreferrer"
											className="flex flex-col">
											<p className="font-bold text-gray-700 text-xl my-2 mb-1">
												{item.name}
											</p>
										</a>
										<div className="flex items-center">
											{[...Array(item.stars)].map((_, i) => (
												<span key={i} className="text-yellow-500">
													★
												</span>
											))}
										</div>
									</div>
								</div>
								{/* <a
									href={item.teamLink}
									target="_blank"
									rel="noopener noreferrer"
									className="text-blue-500 hover:underline mt-4">
									Read Full Team
								</a> */}
							</div>
						))}
					</div>
				</PGtab>
			</PGtabs>
		</div>
	);
}

class BuilderWelcome extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: true };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}

	render() {
		var { postData, appData, addNotifications, customerData } = this.props;

		return (
			<Html
				postData={postData}
				addNotifications={addNotifications}
				customerData={customerData}
				appData={appData}
				warn={this.state.showWarning}
			/>
		);
	}
}

export default BuilderWelcome;
