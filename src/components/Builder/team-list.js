

const { Component, RawHTML, useState, useEffect } = wp.element;

import { ReactSortable } from "react-sortablejs";
import { PanelBody, RangeControl, Button, ButtonGroup, Panel, PanelRow, Dropdown, DropdownMenu, SelectControl, ColorPicker, ColorPalette, ToolsPanelItem, ComboboxControl, Spinner, CustomSelectControl, Popover, __experimentalInputControl as InputControl, } from '@wordpress/components'
import apiFetch from '@wordpress/api-fetch';
import {
	Icon,
	styles,
	close,
	plus,
	key,
	check,
	typography,
	textColor,
	lockSmall,
	category,
	atSymbol,
	settings,
	upload,
	color,
	plusCircle,
	download,
	arrowRight,
	brush,
	code,
	addCard,
	help,
	shortcode,
	copySmall,
	trash,
	addSubmenu,
	pencil,
} from "@wordpress/icons";

var myStore = wp.data.select('postgrid-shop');
import PGinputText from "../input-text";



function Html(props) {

	if (!props.warn) {
		return null;
	}

	var isLoaded = props.isLoaded;
	var selectTestimonial = props.selectTestimonial;
	var activeTestimonial = props.activeTestimonial;
	var addNotifications = props.addNotifications;
	var setHelp = props.setHelp;





	var [searchPrams, setsearchPrams] = useState({ search: "" }); // Using the hook.
	var [posts, setPosts] = useState(null); // Using the hook.
	var [pagination, setPagination] = useState({ currentPage: 1 }); // Using the hook.
	var [dataLoaded, setdataLoaded] = useState(false); // Using the hook.
	var [isLoading, setisLoading] = useState(false); // Using the hook.
	var [deleteConfirm, setdeleteConfirm] = useState({ id: "", confirm: false }); // Using the hook.
	var [rename, setrename] = useState({ id: "", confirm: false }); // Using the hook.


	const copyData = (data) => {
		navigator.clipboard
			.writeText(data)
			.then(() => {
				addNotifications({
					title: "Copied to clipboard!",
					content:
						"Use the shortcode in page or post conent where you want to display.",
					type: "success",
				});
			})
			.catch((err) => { });
	};





	var queryArgs = [
		{
			"id": "postType",
			"val": [
				"team"
			]
		},
		{
			"id": "postStatus",
			"val": [
				"publish"
			]
		},
		{
			"id": "s",
			"val": ""
		},
		{
			"id": "order",
			"val": "DESC"
		},
		{
			"id": "orderby",
			"val": [
				"date"
			]
		},
		{
			"id": "postsPerPage",
			"val": "20"
		},
		{
			"id": "paged",
			"val": "1"
		}
	]


	function Prev() {

	}

	useEffect(() => {

		setisLoading(true);

		queryArgs.map(item => {

			var id = item.id;

			if (id == "paged") {
				item.val = pagination.currentPage;
			}
			if (id == "s") {
				item.val = searchPrams.search;
			}



		})





		apiFetch({
			path: "/team/v2/post_list",
			method: "POST",
			data: {
				queryArgs: queryArgs,
				_wpnonce: team_builder_js._wpnonce,

			},
		}).then((res) => {

			setisLoading(false);

			if (res.posts == undefined) {
				setPosts([]);
				addNotifications({ title: "No Items Found", content: "It seems there is no items in the list.", type: "success" })
			} else {
				setPosts(res.posts);
				addNotifications({ title: "Team Loaded", content: "All Team loaded, Now click to pick one to edit.", type: "success" })
			}




		});






	}, [isLoaded, pagination.currentPage, searchPrams.search]);




	function create_post() {


		setisLoading(true);
		apiFetch({
			path: "/team/v2/create_post",
			method: "POST",
			data: { postTitle: searchPrams.search, },
		}).then((res) => {

			if (res.error) {
				addNotifications({
					title: "There is an Error!",
					content: res.errorMessage,
					type: "error",
				});
			}
			if (res.success) {
				var postsX = [...posts];

				postsX.unshift({ ID: res.id, post_content: "", post_author: 0, post_title: searchPrams.search });

				setPosts(postsX)

				addNotifications({

					title: "Team Create!",
					content: res.successMessage,
					type: "success",
				});
			}



			setisLoading(false);
			if (res.status) {
			}
		});
	}

	function update_post_title(newValue, postId) {


		setisLoading(true);
		apiFetch({
			path: "/team/v2/update_post_title",
			method: "POST",
			data: { postTitle: newValue, postId: postId },
		}).then((res) => {

			console.log(res);


			if (res.error) {
				addNotifications({
					title: "There is an Error!",
					content: res.errorMessage,
					type: "error",
				});
			}
			if (res.success) {
				//var postsX = [...posts];

				//postsX.unshift({ ID: res.id, post_content: "", post_author: 0, post_title: searchPrams.search });

				//setPosts(postsX)

				addNotifications({

					title: "Team Title Updated!",
					content: res.successMessage,
					type: "success",
				});
			}



			setisLoading(false);
			if (res.status) {
			}
		});
	}









	function duplicate_post(postId) {


		setisLoading(true);
		apiFetch({
			path: "/team/v2/duplicate_post",
			method: "POST",
			data: { postId: postId, },
		}).then((res) => {

			if (res.error) {
				addNotifications({
					title: "There is an Error!",
					content: res.errorMessage,
					type: "error",
				});
			}
			if (res.success) {

				var postsX = [...posts];


				postsX.unshift({ ID: res.id, post_title: res.post_title });
				setPosts(postsX)

				addNotifications({
					title: "Team duplicated!",
					content: res.successMessage,
					type: "success",
				});
			}



			setisLoading(false);
			if (res.status) {
			}
		});
	}
	function delete_post(postId, index) {

		if (!deleteConfirm) {
			return;
		}

		setisLoading(true);
		apiFetch({
			path: "/team/v2/delete_post",
			method: "POST",
			data: { postId: postId, },
		}).then((res) => {

			if (res.error) {
				addNotifications({
					title: "There is an Error!",
					content: res.errorMessage,
					type: "error",
				});
			}
			if (res.success) {



				var postsX = [...posts];

				postsX.splice(index, 1);

				setPosts(postsX)
				//posts.unshift({ ID: res.id, post_title: res.post_title });

				addNotifications({
					title: "Team deleted!",
					content: res.successMessage,
					type: "success",
				});

				setdeleteConfirm({ id: "", confirm: false });

			}



			setisLoading(false);
			if (res.status) {
			}
		});
	}








	return (
		<div className="">

			<div className="my-4 flex items-center gap-3">
				<PGinputText
					value={searchPrams.search}
					placeholder={"Search.../Add New..."}
					className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
					onChange={(newVal) => {
						var searchPramsX = { ...searchPrams };
						searchPramsX.search = newVal;
						setsearchPrams(searchPramsX);
						const timer = setTimeout(() => {
							// Update the debounced value after delay
						}, 3000); // 300ms debounce delay
						return () => clearTimeout(timer); // Cleanup timer on value change or unmount
					}}
				/>

				<div
					className="flex items-center  gap-2 py-2 px-3 cursor-pointer  capitalize bg-gray-700 text-white font-medium rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
					onClick={(ev) => {
						create_post();
					}}>
					<Icon fill={"#fff"} icon={addCard} />
					<span>Create</span>
				</div>
				<span
					className="cursor-pointer" title="Click to know more"
					onClick={() => {
						setHelp({
							id: "createTestimonial",
							enable: true,
						});
					}}>
					<Icon icon={help} />
				</span>
			</div>

			{posts == null && (
				<div className="p-3 my-5 bg-orange-400 ">No Items, Please Create First One!</div>
			)}

			{posts != null && (
				<>
					{posts.map((item, index) => {
						return (
							<div className="border-0 border-b border-solid border-[#ddd]">
								<div
									className="flex justify-between align-middle items-center p-3  hover:bg-slate-300 cursor-pointer"
									key={index}
									onClick={(ev) => {
										selectTestimonial(item.ID);

										addNotifications({
											title: "Ready to Edit",
											content: "Now go to Edit panel to customize team.",
											type: "success",
										});
									}}>

									<div className="flex  align-middle items-center gap-2  "
									>

										<div className="text-base mb-2">{item.post_title}</div>

									</div>
									{activeTestimonial == item.ID && (
										<span>
											<Icon icon={check} />
										</span>
									)}
								</div>

								{activeTestimonial == item.ID && (
									<>
										<div className=" px-3 flex flex-wrap align-middle items-center text-xs gap-3 my-2">
											<div className="">#{item.ID}</div>
											<div className="cursor-pointer flex items-center" onClick={(ev) => {
												duplicate_post(item.ID);
											}}>
												<Icon icon={copySmall} size="20" />
												Duplicate</div>



											<div className="cursor-pointer text-red-700 flex items-center" title={"Delete Post"} onClick={(ev) => {
												setdeleteConfirm({ id: item.ID, confirm: true });
												if (deleteConfirm.confirm) {
													delete_post(item.ID, index);
												}

											}}>
												<Icon icon={trash} size="20" />
												{deleteConfirm.id == item.ID && (
													<>
														{deleteConfirm && ("Confirm")}
													</>
												)}
												{deleteConfirm.id != item.ID && (
													<>
														{deleteConfirm && ("Delete")}
													</>
												)}


											</div>
											<div className="cursor-pointer flex items-center" title="Copy Shortcodes" onClick={() => {
												var str = `[team_builder id="${item.ID}"]`;

												copyData(str);
											}}><Icon icon={copySmall} size="20" /> Shortcode</div>
											<div className="cursor-pointer flex items-center" title="Rename" onClick={() => {

												if (rename.id.length == 0) {
													setrename({ id: item.ID, confirm: false });
												} else {
													setrename({ id: "", confirm: false });
												}



											}}><Icon icon={pencil} size="20" /> Rename</div>




										</div>



										{rename.id == item.ID && (
											<div className="my-4 flex items-center justify-between gap-3">
												<PGinputText
													placeholder={item.post_title}
													value={item.post_title}
													className=" px-2 !rounded-none border !border-[#8c8f94] !border-solid w-full"
													onChange={(newVal) => {

														var postsX = [...posts];
														postsX[index].post_title = newVal
														setPosts(postsX)

														const timer = setTimeout(() => {

															// Update the debounced value after delay
															update_post_title(newVal, item.ID);
														}, 3000); // 300ms debounce delay
														return () => clearTimeout(timer); // Cleanup timer on value change or unmount
													}}
												/>



											</div>
										)}



									</>

								)}



							</div>
						);
					})}
				</>
			)}

			<div className="flex py-5 justify-between px-2">
				<div
					className="bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
					onClick={(ev) => {
						if (pagination.currentPage > 1) {
							var currentPage = pagination.currentPage - 1;
							setPagination({ currentPage: currentPage });
						}
					}}>
					Prev
				</div>
				<div
					className="bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
					onClick={(ev) => {
						var currentPage = pagination.currentPage + 1;

						setPagination({ currentPage: currentPage });
					}}>
					Next
				</div>
			</div>
		</div>
	);






}

class TestimonialList extends Component {

	constructor(props) {
		super(props);
		this.state = { showWarning: true, isLoaded: false };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}


	componentDidMount() {
		setTimeout(() => {
			this.setState(state => ({
				isLoaded: !state.isLoaded
			}));
		},
			1000)
	}

	handleToggleClick() {
		this.setState(state => ({
			showWarning: !state.showWarning
		}));
	}



	render() {

		var {
			selectTestimonial,
			activeTestimonial,
			setHelp,
			addNotifications
		} = this.props;







		return (


			<Html selectTestimonial={selectTestimonial} activeTestimonial={activeTestimonial} warn={this.state.showWarning} isLoaded={this.state.isLoaded} setHelp={setHelp} addNotifications={addNotifications}
			/>


		)
	}
}













export default TestimonialList;