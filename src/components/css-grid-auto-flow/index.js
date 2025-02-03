const { Component, RawHTML } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown, ToggleControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var args = {
		column: { label: "column", value: "column" },
		row: { label: "row", value: "row" },
		dense: { label: "dense", value: "dense" },
		"column-dense": { label: "column dense", value: "column-dense" },
		"row-dense": { label: "row dense", value: "row-dense" },
		revert: { label: "revert", value: "revert" },
		unset: { label: "unset", value: "unset" },
		inherit: { label: "inherit", value: "inherit" },
		initial: { label: "initial", value: "initial" },
	};
	const [valArgs, setValArgs] = useState(props.val.split(" "));
	const [align, setalign] = useState(valArgs[0]);
	const [isImportant, setImportant] = useState(
		valArgs[1] == undefined ? false : true
	);
	return (
		<div className="flex justify-between items-center">
			<Dropdown
				position="bottom"
				renderToggle={({ isOpen, onToggle }) => (
					<Button
						title={__("Place Items", "team")}
						onClick={onToggle}
						aria-expanded={isOpen}>
						{/* <div className=" ">{props.val ? args[props.val].label : 'Select...'}</div> */}
						<div className=" ">
							{args[align] == undefined
								? __("Select...", "team")
								: args[align].label}
						</div>
						{/* <div className=" ">{val ? val : 'Select...'}</div> */}
					</Button>
				)}
				renderContent={() => (
					<div className="w-32">
						{Object.entries(args).map((args) => {
							var index = args[0];
							var x = args[1];
							return (
								<div
									className={
										"px-3 py-1 border-b block hover:bg-gray-400 cursor-pointer"
									}
									onClick={(ev) => {
										// props.onChange(x.value, 'alignItems');
										setalign(x.value);
										if (isImportant) {
											props.onChange(x.value + " !important", "gridAutoFlow");
										} else {
											props.onChange(x.value, "gridAutoFlow");
										}
									}}>
									{!x.value && <div>{__("Reset", "team")}</div>}
									{x.value && <>{x.label}</>}
								</div>
							);
						})}
					</div>
				)}
			/>
			<ToggleControl
				help={
					isImportant
						? __("Important (Enabled)", "team")
						: __("Important?", "team")
				}
				checked={isImportant}
				onChange={(arg) => {
					setImportant((isImportant) => !isImportant);
					if (isImportant) {
						props.onChange(align, "gridAutoFlow");
					} else {
						props.onChange(align + " !important", "gridAutoFlow");
					}
				}}
			/>
		</div>
	);
}
class PGcssGridAutoFlow extends Component {
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
		const { val, onChange } = this.props;
		return <Html val={val} onChange={onChange} warn={this.state.showWarning} />;
	}
}
export default PGcssGridAutoFlow;
