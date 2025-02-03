const { Component, RawHTML, useState, useEffect } = wp.element;
import { Button, Dropdown } from "@wordpress/components";
import { Icon, chevronDown, chevronLeft, chevronRight } from "@wordpress/icons";

function MyFunction(props) {
	if (!props.warn) {
		return null;
	}

	var navItemLabelClass = props.navItemLabelClass;
	var stickyNavs = props.stickyNavs;
	var orientation = props.orientation; // vertical, horizontal
	var tabsWrapperClass = props.tabsWrapperClass;
	var navItemsWrapClass = props.navItemsWrapClass;
	var contentClass = (props.contentClass == undefined) ? "py-3" : props.contentClass;
	var navItemClass = (props.navItemClass == undefined) ? "bg-gray-200" : props.navItemClass;
	var navItemSelectedClass = (props.navItemSelectedClass == undefined) ? "!bg-gray-400" : props.navItemSelectedClass;

	const [selected, setSelected] = useState(props.activeTab);
	const [scrollTo, setscrollTo] = useState(200);
	var content;

	useEffect(() => {
		setSelected(props.activeTab)

	}, [props.activeTab]);

	props.children.map((child) => {
		if (selected == child.props.name) {
			content = child.props.children;
		}
	});

	function scrollPrev() {
		const tabsNavs = document.querySelector(".tabsNavs");
		if (tabsNavs == null) return;

		tabsNavs.scrollBy({
			left: -scrollTo,
			behavior: "smooth",
		});
	}

	function scrollNext() {
		const tabsNavs = document.querySelector(".tabsNavs");
		if (tabsNavs == null) return;

		tabsNavs.scrollBy({
			left: scrollTo,
			behavior: "smooth",
		});
	}
	function onWheel(ev) {
		// ev.preventDefault();
		ev.stopPropagation();

		const tabsNavs = document.querySelector(".tabsNavs");

		tabsNavs?.scrollBy({
			left: ev.deltaY,
			behavior: "smooth",
		});
	}

	return (
		<div className={
			orientation == "vertical"
				? `flex tabsWrapper ${tabsWrapperClass}`
				: ` relative tabsWrapper ${tabsWrapperClass}`
		}>

			{stickyNavs && (
				<div className="sticky top-0 z-[999]">
					<div
						className={
							orientation == "vertical"
								? "block w-[200px] "
								: `flex overflow-hidden  tabsNavs cursor-move ${navItemsWrapClass}`
						}



						onWheel={onWheel}>
						{props.tabs.map((tab, index) => {
							return (
								<div
									className={`${navItemClass} flex justify-between flex-none   items-center grow  font-medium  text-slate-900 p-2 cursor-pointer hover:bg-gray-300 ${tab.name == selected ? navItemSelectedClass : navItemClass
										} ${orientation == "vertical" ? "       " : ""}`}
									onClick={(ev) => {
										props.onSelect(tab);
										setSelected(tab.name);
									}} key={index}>
									<div
										className={`flex ${navItemLabelClass} ${orientation == "vertical" ? "" : "flex-col"
											} justify-center items-center`}>
										<Icon
											fill="#404040"
											icon={tab.icon}
											size={24}
											// className="mr-2 w-[20px] text-green-500"
											className=" text-green-500"
										/>
										<span className="text-sm">{tab.title}</span>
									</div>

									{tab.isPro != null && tab.isPro && (
										<span
											className="pg-bg-color text-white px-2  text-sm rounded-sm"
											onClick={(ev) => {
												window.open("https://comboblocks.com/pricing/", "_blank");
											}}>
											Pro
										</span>
									)}
								</div>
							);
						})}
					</div>
				</div>
			)}
			{!stickyNavs && (
				<div
					className={
						orientation == "vertical"
							? "block w-[200px] "
							: `flex overflow-hidden  tabsNavs cursor-move ${navItemsWrapClass}`
					}

					onWheel={onWheel}>
					{props.tabs.map((tab, index) => {
						return (
							<div
								className={`${navItemClass} flex justify-between flex-none    items-center   font-medium  text-slate-900 p-2 cursor-pointer hover:bg-gray-300 ${tab.name == selected ? navItemSelectedClass : navItemClass
									} ${orientation == "vertical" ? "       " : ""}`}
								onClick={(ev) => {
									props.onSelect(tab);
									setSelected(tab.name);
								}} key={index}>
								<div
									className={`flex ${navItemLabelClass} ${orientation == "vertical" ? "" : ""
										} justify-center items-center`}>
									<Icon
										fill="#404040"
										icon={tab.icon}
										size={24}
										// className="mr-2 w-[20px] text-green-500"
										className=" text-green-500"
									/>
									<span className="text-sm">{tab.title}</span>
								</div>

								{tab.isPro != null && tab.isPro && (
									<span
										className="pg-bg-color text-white px-2  text-sm rounded-sm"
										onClick={(ev) => {
											window.open("https://comboblocks.com/pricing/", "_blank");
										}}>
										Pro
									</span>
								)}
							</div>
						);
					})}
				</div>
			)}

			<div className={`tabContent  ${contentClass}`}>{content}</div>
		</div>
	);
}

class PGtabs extends Component {
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
		const {
			activeTab,
			orientation,
			activeClass,
			contentClass,
			stickyNavs,
			tabsWrapperClass,
			navItemsWrapClass,
			navItemClass,

			navItemLabelClass,
			navItemSelectedClass,
			onSelect,
			tabs,
			children,
		} = this.props;

		return (
			<div>
				<MyFunction
					children={children}
					tabs={tabs}
					orientation={orientation}
					contentClass={contentClass}
					stickyNavs={stickyNavs}
					tabsWrapperClass={tabsWrapperClass}
					navItemsWrapClass={navItemsWrapClass}
					navItemClass={navItemClass}
					navItemLabelClass={navItemLabelClass}
					navItemSelectedClass={navItemSelectedClass}
					onSelect={onSelect}
					activeTab={activeTab}
					warn={this.state.showWarning}
				/>
			</div>
		);
	}
}

export default PGtabs;


