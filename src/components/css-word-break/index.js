const { Component, RawHTML } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown, ToggleControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var args = {
		normal: { label: "normal", value: "normal" },
		"break-all": { label: "break-all", value: "break-all" },
		"keep-all": { label: "keep-all", value: "keep-all" },
		"break-word": { label: "break-word", value: "break-word" },
	};
	const [valArgs, setValArgs] = useState(props.val.split(" "));
	const [align, setalign] = useState(valArgs[0]);
	const [isImportant, setImportant] = useState(
		valArgs[1] == undefined ? false : true
	);
	return (
		<div className="flex justify-between items-center pg-setting-css-components">
			<Dropdown
				position="bottom"
				renderToggle={({ isOpen, onToggle }) => (
					<Button
						title={__("Clear", "team")}
						onClick={onToggle}
						aria-expanded={isOpen}>
						{/* <div className=" ">{val ? args[val].label : 'Select...'}</div> */}
						<div className=" ">
							{args[align] == undefined
								? __("Select...", "team")
								: args[align].label}
						</div>
					</Button>
				)}
				renderContent={() => (
					<div className="w-32 pg-font">
						{Object.entries(args).map((args) => {
							var index = args[0];
							var x = args[1];
							return (
								<div
									className={
										"px-3 py-1 border-b block hover:bg-gray-400 cursor-pointer"
									}
									onClick={(ev) => {
										// onChange(x.value, 'wordBreak');
										setalign(x.value);
										if (isImportant) {
											props.onChange(x.value + " !important", "wordBreak");
										} else {
											props.onChange(x.value, "wordBreak");
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
						props.onChange(align, "wordBreak");
					} else {
						props.onChange(align + " !important", "wordBreak");
					}
				}}
			/>
		</div>
	);
}
class PGcssWordBreak extends Component {
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
export default PGcssWordBreak;
