<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friendship extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Friendship_model');
    }

    public function index() {
        $user = $this->jwt->verify($this->jwt->get_token_from_request());
        if (!$user) return $this->response_json(['message' => 'Unauthorized'], 401);

        $friends = $this->Friendship_model->get_friends($user->user_id);
        return $this->response_json(['status' => true, 'data' => $friends]);
    }

    public function follow() {
        $user = $this->jwt->verify($this->jwt->get_token_from_request());
        if (!$user) return $this->response_json(['message' => 'Unauthorized'], 401);

        $input = $this->get_json_input();
        $friend_id = isset($input['friend_id']) ? (int)$input['friend_id'] : 0;

        if ($friend_id <= 0) {
            return $this->response_json(['status' => false, 'message' => 'Valid Friend ID is required'], 400);
        }

        if ($friend_id === (int)$user->user_id) {
            return $this->response_json(['status' => false, 'message' => 'You cannot follow yourself'], 400);
        }

        $result = $this->Friendship_model->follow($user->user_id, $friend_id);
        
        if ($result) {
            return $this->response_json(['status' => true, 'message' => 'Followed']);
        } else {
            return $this->response_json(['status' => false, 'message' => 'Failed to follow'], 500);
        }
    }

    public function unfollow() {
        $user = $this->jwt->verify($this->jwt->get_token_from_request());
        if (!$user) return $this->response_json(['message' => 'Unauthorized'], 401);

        $input = $this->get_json_input();
        $friend_id = isset($input['friend_id']) ? (int)$input['friend_id'] : 0;

        if ($friend_id <= 0) {
            return $this->response_json(['status' => false, 'message' => 'Valid Friend ID is required'], 400);
        }

        $this->Friendship_model->unfollow($user->user_id, $friend_id);
        return $this->response_json(['status' => true, 'message' => 'Unfollowed']);
    }
}
