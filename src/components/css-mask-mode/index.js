const { Component, RawHTML } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown, ToggleControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var args = {
		"match-source": { label: "Match Source", value: "match-source" },
		luminance: { label: "Luminance", value: "luminance" },
		alpha: { label: "Alpha", value: "alpha" },
		"revert-layer": { label: "revert-layer", value: "revert-layer" },
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
						title={__("Background Blend Mode", "team")}
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
										// onChange(x.value, 'maskMode');
										setalign(x.value);
										if (isImportant) {
											props.onChange(x.value + " !important", "maskMode");
										} else {
											props.onChange(x.value, "maskMode");
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
						props.onChange(align, "maskMode");
					} else {
						props.onChange(align + " !important", "maskMode");
					}
				}}
			/>
		</div>
	);
}
class PGcssMaskMode extends Component {
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
export default PGcssMaskMode;
