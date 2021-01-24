<?php
class ControllerModuleTelegram extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/telegram');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');
        $id = $this->model_extension_module->getModulesByCode('telegram');
        $this->mylog->write(serialize($id));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('telegram', $this->request->post);
			} else {

				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		//$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_bot_token'] = $this->language->get('entry_bot_token');
		$data['entry_chat_id'] = $this->language->get('entry_chat_id');
        $data['entry_chat_id_help'] = $this->language->get('entry_chat_id_help');
        $data['entry_bot_token_help'] = $this->language->get('entry_bot_token_help');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_product'] = $this->language->get('help_product');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error[''])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['chat_id'])) {
			$data['error_chat_id'] = $this->error['chat_id'];
		} else {
			$data['error_chat_id'] = '';
		}




		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/telegram', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/telegram', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/telegram', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/telegram', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('catalog/product');

		$data['products'] = array();



		if (isset($this->request->post['bot_token'])) {
			$data['bot_token'] = $this->request->post['bot_token'];
		} elseif (!empty($module_info)) {
			$data['bot_token'] = $module_info['bot_token'];
		} else {
			$data['bot_token'] = 5;
		}

		if (isset($this->request->post['chat_id'])) {
			$data['chat_id'] = $this->request->post['chat_id'];
		} elseif (!empty($module_info)) {
			$data['chat_id'] = $module_info['chat_id'];
		} else {
			$data['chat_id'] = 200;
		}



		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/telegram.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/telegram')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['chat_id']) {
			$this->error['chat_id'] = $this->language->get('error_chat_id');
		}



		return !$this->error;
	}

	protected function install(){

	}
}