const { Component, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";
import { __ } from "@wordpress/i18n";

import { PanelRow, Spinner } from "@wordpress/components";
import { Icon, brush, category, close, cog, columns } from "@wordpress/icons";
import PGDropdown from "../dropdown";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";

import BuilderView from "../../components/BuilderView";
import BuilderWelcome from "../../components/BuilderWelcome";
import EditTestimonialGrid from "../../components/edit-team-grid";

import PGtabs from "../../components/tabs";

import PGtab from "../../components/tab";

import TestimonialList from "./team-list";
import EditTestimonialCarousel from "../edit-team-carousel";
import GenerateCss from "./generate-css";
import Help from "./help";
import Notify from "./notify";
import Templates from "./templates";
import teamSliderDefaultData from "./team-carousel-default-data";
import teamFilterableDefaultData from "./team-fliterable-default-data";
import teamGridDefaultData from "./team-grid-default-data";
import teamMasonryDefaultData from "./team-masonry-default-data";
import EditTestimonialFilterable from "../edit-team-filterable";
import EditTestimonialMasonry from "../edit-team-masonry";

function Html(props) {
	if (!props.warn) {
		return null;
	}

	var appData = props.appData;

	var [activeTestimonial, setActiveTestimonial] = useState(null);
	var [postData, setpostData] = useState({
		ID: null,
		post_content: {},
		post_title: "",
	});
	var [teamData, setteamData] = useState(postData?.post_content);
	var [globalOptions, setglobalOptions] = useState(teamData.globalOptions); // Using the hook.

	var [isLoading, setisLoading] = useState(false);
	var [pleaseUpdate, setpleaseUpdate] = useState(false);
	const [optionData, setoptionData] = useState({});
	const [roles, setroles] = useState([]);
	var [needSave, setneedSave] = useState(false);
	var [toggleSettings, settoggleSettings] = useState(false);

	var [notifications, setnotifications] = useState([]);
	var [help, sethelp] = useState({ id: "", enable: false });
	var [customerData, setcustomerData] = useState({ id: "", isPro: false });
	var [isProFeature, setisProFeature] = useState(true);

	var viewTypeArgs = {
		teamGrid: { label: "Team Grid", value: "teamGrid" },
		teamSlider: {
			label: "Team Slider/Carousel",
			value: "teamSlider",
		},
		// filterable: {
		// 	label: "Filterable",
		// 	value: "filterable",
		// 	// isPro: true
		// },
		teamMasonry: {
			label: "Masonry",
			value: "teamMasonry",
			// isPro: true
		},
	};

	useEffect(() => {
		setteamData(postData.post_content);
		//setglobalOptions(postData.post_content.globalOptions);
	}, [postData]);

	useEffect(() => {
		//setglobalOptions(teamData.globalOptions);
	}, [teamData]);

	useEffect(() => {

		if (globalOptions?.viewType == "teamGrid") {
			setpostData({ ...postData, post_content: teamGridDefaultData });
		}
		if (globalOptions?.viewType == "teamSlider") {
			setpostData({ ...postData, post_content: teamSliderDefaultData });
		}
		if (globalOptions?.viewType == "teamMasonry") {
			setpostData({ ...postData, post_content: teamMasonryDefaultData });
		}



	}, [globalOptions]);

	useEffect(() => {
		setisLoading(true);

		if (activeTestimonial == null) return;

		apiFetch({
			path: "/team/v2/team_data",
			method: "POST",
			data: {
				postId: activeTestimonial,
				_wpnonce: team_builder_js._wpnonce,
			},
		}).then((res) => {
			setisLoading(false);


			if (res.post_content == null) {
				res.post_content = teamGridDefaultData;
			}

			setpostData(res);
		});
	}, [activeTestimonial]);

	useEffect(() => {
		setnotifications(notifications);

		const timer = setTimeout(() => {
			setnotifications([]); // Update the debounced value after delay
		}, 5000); // 300ms debounce delay

		return () => clearTimeout(timer); // Cleanup timer on value change or unmount
	}, [notifications]);

	useEffect(() => {
		if (customerData.isPro) {
			setisProFeature(false);
		}
	}, [customerData]);

	function handleAlertConfirmation() {
		if (confirm("Are you sure you want to reset the option data?")) {
			resetOptionData();
		}
	}

	function resetOptionData() {
		setoptionData(optionDataDefault);
	}

	function updateOption() {
		setisLoading(true);
		apiFetch({
			path: "/team/v2/update_options",
			method: "POST",
			data: { name: "team_settings", value: optionData },
		}).then((res) => {
			setisLoading(false);
			if (res.status) {
				setneedSave(false);
			}
		});
	}

	function addNotifications(notification) {
		var notificationsX = [...notifications];
		notificationsX.push(notification);
		setnotifications(notificationsX);
	}
	function setHelp(helpX) {
		sethelp(helpX);
	}

	function selectTestimonial(args) {
		setActiveTestimonial(args);
	}
	function onChangeStyle(args) {
		var teamDataX = { ...teamData };


		teamDataX.reponsiveCss = escapeHTML(args);
		//teamDataX.reponsiveCss = (args);
		setteamData(teamDataX);
	}

	function onChangeTestimonial(args) {

		console.log(args);

		var postDataX = { ...postData };
		postDataX.post_content = args;
		setpostData(postDataX);

		setteamData(args);

		setpleaseUpdate(true);
	}

	function onUpdateTestimonial() {
		setisLoading(true);


		var content = teamData;
		//content = JSON.stringify(content);


		apiFetch({
			path: "/team/v2/update_post_data",
			method: "POST",
			data: {
				postId: activeTestimonial,
				content: content,
				_wpnonce: team_builder_js._wpnonce,
			},
		}).then((res) => {
			setisLoading(false);
			setpleaseUpdate(false);
			addNotifications({
				title: "Data Saved!",
				content: "You change successfully saved!.",
				type: "success",
			});
		});
	}

	useEffect(() => {
		apiFetch({
			path: "/team/v2/user_roles_list",
			method: "POST",
			data: {},
		}).then((res) => {
			var rolesX = [];
			Object.entries(res?.roles).map((role) => {
				var index = role[0];
				var val = role[1];
				rolesX.push({ label: val, value: index });
			});

			setroles(rolesX);
		});
	}, []);

	useEffect(() => {
		setisLoading(true);
		apiFetch({
			path: "/team/v2/get_options",
			method: "POST",
			data: { option: "team_settings" },
		}).then((res) => {
			if (res.length != 0) {
				var resX = { ...res };
				if (resX?.license_key.length > 0) {
					setcustomerData({ ...customerData, isPro: true });
				}

				setoptionData(resX);
			}
			setisLoading(false);
		});
	}, []);

	function escapeHTML(str) {
		const map = {
			"&": "&amp;",
			"<": "&lt;",
			">": "&gt;",
			'"': "&quot;",
			"'": "&#039;",
		};
		return str.replace(/[&<>"']/g, function (match) {
			return map[match];
		});
	}


	return (
		<div className="pg-setting-input-text pg-dashboard">
			<div className="flex h-[800px]">
				<div className="w-[500px] overflow-y-scroll light-scrollbar">
					<div className="flex items-center justify-between bg-blue-700 py-3 px-3">
						<div>
							<div className="flex items-center align-middle gap-3">
								<div className="text-xl text-white">Team</div>
								<div className="text-xs text-white flex items-center gap-2">
									{/* <span>2.3.5</span>{" "} */}
									<span className="bg-lime-600 px-3 py-1 rounded-md">Beta</span>
								</div>
							</div>
							<div className="text-sm text-white">By PickPlugins</div>
						</div>

						<div>
							<div
								className={`py-1 px-2 cursor-pointer  capitalize  text-white font-medium rounded hover:bg-gray-700 focus:outline-none focus:bg-gray-700 ${toggleSettings ? "bg-gray-800" : "bg-gray-500"
									}`}
								onClick={(ev) => {
									settoggleSettings(!toggleSettings);
								}}>
								{isLoading && <Spinner />}
								{!isLoading && (
									<>
										{toggleSettings && <Icon fill={"#fff"} icon={close} />}
										{!toggleSettings && <Icon fill={"#fff"} icon={cog} />}
									</>
								)}
							</div>
						</div>
					</div>

					{toggleSettings && (
						<>
							<div className="relative bg-white">
								<div className="px-4 py-2 bg-slate-400 text-white  ">
									<div className="text-xl text-white mb-4">
										Team Settings
									</div>

									<div className="flex gap-2 items-center">
										<div
											className="bg-amber-500 rounded-sm text-md p-2 px-4 cursor-pointer pg-font text-white "
											onClick={(ev) => {
												handleAlertConfirmation();
											}}>
											{__("Reset", "team")}
										</div>
										<div
											className="bg-green-700 rounded-sm text-md p-2 px-4 cursor-pointer pg-font text-white flex items-center"
											onClick={(ev) => {
												updateOption();
											}}>
											<span>{__("Save", "team")}</span>
											{needSave && (
												<span className="w-5 inline-block h-5 ml-3 rounded-xl text-center bg-red-500">
													!
												</span>
											)}
										</div>
									</div>
								</div>

								<div className="p-3">
									<div className="my-5">
										<label className=" text-base" htmlFor="">
											{__("Allow access by roles", "team")}
										</label>
										<PGinputSelect
											val={optionData?.user_roles ?? []}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[250px]"
											options={roles}
											onChange={(newVal) => {
												var optionsX = {
													...optionData,
													user_roles: newVal,
												};
												setoptionData(optionsX);
											}}
											multiple={true}
										/>
									</div>
									<div className="my-5">
										<label className="text-base" htmlFor="">
											{__("Font-awesome version", "team")}
										</label>
										<PGinputSelect
											val={optionData?.font_aw_version ?? "none"}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[250px]"
											options={[
												{ label: "None", value: "none" },
												{ label: "Version 4+", value: "v_4" },
												{ label: "Version 5+", value: "v_5" },
											]}
											onChange={(newVal) => {
												var optionsX = {
													...optionData,
													font_aw_version: newVal,
												};
												setoptionData(optionsX);
											}}
											multiple={false}
										/>
									</div>

									<div className="my-5">
										<label className="text-base" htmlFor="">
											{__("Enable team preview", "team")}
										</label>
										<PGinputSelect
											val={optionData?.team_preview ?? "no"}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[250px]"
											options={[
												{ label: "No", value: "no" },
												{ label: "Yes", value: "yes" },
											]}
											onChange={(newVal) => {
												var optionsX = {
													...optionData,
													team_preview: newVal,
												};
												setoptionData(optionsX);
											}}
											multiple={false}
										/>
									</div>
									<div className="my-5">
										<label className="text-base" htmlFor="">
											{__("Open AI API Key", "team")}
										</label>

										<PGinputText
											label=""
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[250px]"
											value={optionData?.openaiApiKey ?? ""}
											onChange={(newVal) => {
												var optionsX = {
													...optionData,
													openaiApiKey: newVal,
												};
												setoptionData(optionsX);
											}}
										/>
									</div>
									<div className="my-5">
										<div className="text-base" htmlFor="">
											{__("License Key", "team")}
										</div>

										<PGinputText
											label=""
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[250px]"
											value={optionData?.license_key ?? ""}
											onChange={(newVal) => {
												var optionsX = {
													...optionData,
													license_key: newVal,
												};
												setoptionData(optionsX);
											}}
										/>
									</div>
								</div>
							</div>
						</>
					)}

					{!toggleSettings && (
						<>
							<PGtabs
								activeTab="team"
								orientation=""
								stickyNavs={true}
								contentClass=" bg-white w-full"
								navItemClass="bg-gray-200 px-5 py-3 gap-2 grow "
								navItemLabelClass="flex-col "
								navItemSelectedClass="!bg-white"
								activeClass="active-tab"
								onSelect={(tabName) => { }}
								tabs={[
									{
										name: "team",
										title: "Team",
										icon: columns,
										className: "tab-disable-blocks",
									},
									{
										name: "edit",
										title: "Edit",
										icon: brush,
										className: "tab-disable-blocks",
									},
									{
										name: "templates",
										title: "Templates",
										icon: category,
										className: "tab-disable-blocks",
									},
								]}>
								<PGtab name="team">
									<div className="relative p-3">
										{postData?.post_content == null && (
											<div className="p-3 my-5 bg-orange-400">
												Please choose an team first.
											</div>
										)}

										<TestimonialList
											addNotifications={addNotifications}
											selectTestimonial={selectTestimonial}
											activeTestimonial={activeTestimonial}
											setHelp={setHelp}
										/>
									</div>
								</PGtab>
								<PGtab name="edit">
									{postData?.ID == null && (
										<div className="py-3">
											<div className="my-3 bg-orange-400 p-3  text-white  text-center animate__animated animate__flash animate__repeat-2">
												Please select post from list.
											</div>
										</div>
									)}

									<div className=" ">
										{postData?.ID != null && (
											<>
												<div className="my-4 p-3">
													<PanelRow>
														<label htmlFor="">View Type?</label>
														<PGDropdown
															position="bottom right"
															variant="secondary"
															buttonTitle={
																postData?.post_content?.globalOptions?.viewType
																	? viewTypeArgs[
																		postData?.post_content?.globalOptions
																			?.viewType
																	]?.label
																	: "Choose"
															}
															options={viewTypeArgs}
															onChange={(option, index) => {



																if (
																	confirm("Data will reset, Please confirm?")
																) {

																	if (option.value == "teamGrid") {
																		setpostData({
																			...postData,
																			post_content: teamGridDefaultData,
																		});
																	}
																	if (option.value == "teamSlider") {
																		setpostData({
																			...postData,
																			post_content:
																				teamSliderDefaultData,
																		});
																	}
																	if (option.value == "filterable") {
																		setpostData({
																			...postData,
																			post_content:
																				teamFilterableDefaultData,
																		});
																	}
																	if (option.value == "teamMasonry") {
																		setpostData({
																			...postData,
																			post_content:
																				teamMasonryDefaultData,
																		});
																	}

																}
															}}
															values=""></PGDropdown>
													</PanelRow>
												</div>



												{postData.post_content.globalOptions?.viewType ==
													"teamGrid" && (
														<EditTestimonialGrid
															onChange={onChangeTestimonial}
															addNotifications={addNotifications}
															postData={postData}
															customerData={customerData}
															setHelp={setHelp}
														/>
													)}

												{postData.post_content.globalOptions?.viewType ==
													"teamSlider" && (
														<EditTestimonialCarousel
															onChange={onChangeTestimonial}
															addNotifications={addNotifications}
															postData={postData}
															customerData={customerData}
															setHelp={setHelp}
														/>
													)}
												{postData.post_content.globalOptions?.viewType ==
													"filterable" && (
														<EditTestimonialFilterable
															onChange={onChangeTestimonial}
															addNotifications={addNotifications}
															postData={postData}
															customerData={customerData}
															setHelp={setHelp}
														/>
													)}
												{postData.post_content.globalOptions?.viewType ==
													"teamMasonry" && (
														<EditTestimonialMasonry
															onChange={onChangeTestimonial}
															addNotifications={addNotifications}
															postData={postData}
															customerData={customerData}
															setHelp={setHelp}
														/>
													)}


											</>
										)}
									</div>
								</PGtab>
								<PGtab name="templates">
									{postData?.ID == null && (
										<div className="py-3">
											<div className="my-3 bg-orange-400 p-3  text-white  text-center animate__animated animate__flash animate__repeat-2">
												Please select post from list.
											</div>
										</div>
									)}

									<Templates
										onChange={onChangeTestimonial}
										addNotifications={addNotifications}
										postData={postData}
										customerData={customerData}
										setHelp={setHelp}
									/>
								</PGtab>
							</PGtabs>
						</>
					)}
				</div>
				<div className="w-full sticky top-0 overflow-y-scroll">
					<div className="  relative">
						<div className="my-3 hidden bg-orange-400 p-3 ml-5 text-white  text-center animate__animated animate__flash animate__repeat-2">
							<div className="text-xl">
								<i class="fa-solid fa-triangle-exclamation"></i> Please test the
								Team Builder and{" "}
								<span
									className="font-bold cursor-pointer underline"
									onClick={(ev) => {
										settoggleSettings(!toggleSettings);
									}}>
									send us feedbacks.
								</span>
							</div>
							<div>
								Please do not use for old team, we will add migration
								later.
							</div>
						</div>



						{(postData?.ID == null || toggleSettings) && (
							<BuilderWelcome
								appData={appData}
								addNotifications={addNotifications}
								customerData={customerData}
							/>
						)}

						{!toggleSettings && postData?.ID != null && (
							<BuilderView
								pleaseUpdate={pleaseUpdate}
								onUpdate={onUpdateTestimonial}
								isLoading={isLoading}
								onChange={onChangeTestimonial}
								postData={postData}
								id={activeTestimonial}
								addNotifications={addNotifications}
								setHelp={setHelp}
							/>
						)}



						{postData?.ID != null && (
							<GenerateCss postData={postData} onChange={onChangeStyle} />
						)}
					</div>
				</div>
			</div>

			<Notify notifications={notifications} />
			<Help help={help} />
		</div>
	);
}

class Builder extends Component {
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
		var { onChange, appData } = this.props;

		return <Html appData={appData} warn={this.state.showWarning} />;
	}
}

export default Builder;
