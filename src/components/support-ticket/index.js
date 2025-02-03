

const { Component } = wp.element;
import { applyFilters } from '@wordpress/hooks';
import apiFetch from '@wordpress/api-fetch';
import { memo, useMemo, useState, useEffect } from '@wordpress/element'
import { InspectorControls, BlockControls, AlignmentToolbar, RichText, __experimentalLinkControl as LinkControl } from '@wordpress/block-editor'
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Icon, styles, close, settings, download } from '@wordpress/icons';

import { PanelBody, RangeControl, Button, ButtonGroup, Panel, PanelRow, Dropdown, DropdownMenu, SelectControl, ColorPicker, ColorPalette, ToolsPanelItem, ComboboxControl, Spinner, CustomSelectControl, Popover, __experimentalInputControl as InputControl, } from '@wordpress/components'
import PGinputText from '../../components/input-text'
import PGDropdown from '../../components/dropdown'



function Html(props) {
	if (!props.warn) {
		return null;
	}

	const [searchPrams, setsearchPrams] = useState({ title: "", content: '', files: [], budget: 50, email: '', name: "", status: 'idle', statusMessage: '' });
	var [isLoading, setIsLoading] = useState(false);

	const ALLOWED_MEDIA_TYPES = ['image'];

	let budgetArgs = {
		custom: { label: 'Custom', value: '' },
		'50-': { label: 'Less than 50$', value: '50-' },
		50: { label: '50$+', value: 50 },
		100: { label: '100$+', value: 100 },
		200: { label: '200$+', value: 200 },
		300: { label: '300$+', value: 300 },
		500: { label: '500$+', value: 500 },
	};



	useEffect(() => {
		apiFetch({
			path: '/team/v2/get_site_details',
			method: 'POST',
			data: {},
		}).then((res) => {

			setsearchPrams({ ...searchPrams, email: res.email, name: res.name, });

		});
	}, []);




	function senMail() {

		setIsLoading(true);

		if (searchPrams.title.length == 0) {
			setsearchPrams({ ...searchPrams, status: 'fail', statusMessage: "Subejct should not empty" });
			setIsLoading(false);
			return;
		}
		if (searchPrams.content.length == 0) {
			setsearchPrams({ ...searchPrams, status: 'fail', statusMessage: "Details should not empty" });
			setIsLoading(false);
			return;
		}
		if (searchPrams.email.length == 0) {
			setsearchPrams({ ...searchPrams, status: 'fail', statusMessage: "Email should not empty" });
			setIsLoading(false);
			return;
		}



		var htmlBody = '';
		htmlBody += '<p style="font-weight:bold;font-size:18px">' + searchPrams.title + '</p>';
		htmlBody += '<p style="font-weight:bold">Email: ' + searchPrams.email + '</p>';
		htmlBody += '<p></p>';

		htmlBody += searchPrams.content;


		var postData = {

			subject: '#Team Support - ' + searchPrams.title,
			body: htmlBody,
			email_to: 'support@pickplugins.com',
			email_from: searchPrams.email,
			email_from_name: searchPrams.name,
			reply_to: searchPrams.email,
			reply_to_name: searchPrams.name,
			attachments: searchPrams.files,

		}


		apiFetch({
			path: '/team/v2/send_mail',
			method: 'POST',
			data: postData,

		}).then((res) => {

			var mail_sent = res.mail_sent;

			if (mail_sent) {

				setsearchPrams({ ...searchPrams, status: 'success', statusMessage: "" });

			} else {
				setsearchPrams({ ...searchPrams, status: 'fail', statusMessage: "" });
			}

			setTimeout(() => {
				setsearchPrams({ ...searchPrams, status: 'idle', statusMessage: "" });

			}, 4000)


			setIsLoading(false);


		});


	}






	return (
		<div id="requestTemplate" className="pg-setting-input-text">

			<div className='flex items-end justify-end gap-2'>
				<a className='bg-slate-400 px-4 py-2 rounded-sm' target='_blank' href="https://wordpress.org/support/plugin/team/#new-topic-0">Create Ticket at wordpress.org</a>
				<a className='bg-slate-400 px-4 py-2 rounded-sm' target='_blank' href="https://pickplugins.com/create-support-ticket/">Create Ticket at our site</a>
			</div>

			<div className="grid grid-cols-2 gap-5 items-center">
				<div>
					<label for="" className="pg-font mb-3 block  text-base">
						Subjet
					</label>
					<PGinputText
						className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
						type="text"
						placeholder=""
						value={searchPrams.title}
						onChange={(newVal) => {

							setsearchPrams({ ...searchPrams, title: newVal });
						}}
					/>

					<label
						for=""
						className=" pg-font  mt-5 mb-3 block  text-base">
						Details
					</label>
					<RichText
						className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid h-28"
						tagName={"div"}
						value={searchPrams.content}
						allowedFormats={["core/bold", "core/italic", "core/link"]}
						onChange={(content) => {
							setsearchPrams({ ...searchPrams, content: content });
						}}
						placeholder={"Write details about your design..."}
					/>



					<label
						for=""
						className=" mb-3 mt-5 block pg-font   text-base">
						Your Email
					</label>
					<PGinputText
						className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
						type="text"
						placeholder=""
						value={searchPrams.email}
						onChange={(newVal) => {

							setsearchPrams({ ...searchPrams, email: newVal });
						}}
					/>

					<label for="" className=" my-3 block pg-font   text-base">
						Your Name
					</label>
					<PGinputText
						className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
						type="text"
						placeholder=""
						value={searchPrams.name}
						onChange={(newVal) => {

							setsearchPrams({ ...searchPrams, name: newVal });
						}}
					/>
				</div>

				<div className="py-5 px-10">
					<p className="text-base pg-font ">
						By sending mail, you are requested to follow our support terms.
					</p>


					<div
						className="flex bg-blue-600 pg-font  justify-center items-center rounded-md  font-bold text-base text-center cursor-pointer hover:bg-blue-500 px-10 py-3 my-5"
						onClick={(ev) => {
							senMail();
						}}>
						<div className='text-white'>Send Mail</div>
						{isLoading && (
							<div className="text-center">
								<Spinner className="!m-0 !mx-3" />
							</div>
						)}
					</div>

					<p className='text-xs'>We do not collect any other information. Your mail will go to <b>support@pickplugins.com</b></p>

					{searchPrams.status == "success" && (
						<div className=" pg-font  text-green-800 font-bold text-base p-2 px-4">
							Mial has sent. Our team will contact soon.
						</div>
					)}
					{searchPrams.status == "fail" && (
						<div className=" pg-font  text-red-500 font-bold text-base p-2 px-4">
							Sorry, Unable to send mail.
						</div>
					)}
					{searchPrams.status == "fail" && (
						<div className=" pg-font  text-red-500 font-bold text-base p-2 px-4">
							{searchPrams.statusMessage}
						</div>
					)}



				</div>
			</div>
		</div>
	);

}


class PGSupportTicket extends Component {

	constructor(props) {
		super(props);
		this.state = { showWarning: true };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState(state => ({
			showWarning: !state.showWarning
		}));
	}



	render() {

		var {
			onChange,



		} = this.props;








		return (


			<Html warn={this.state.showWarning} />


		)
	}
}


export default PGSupportTicket;