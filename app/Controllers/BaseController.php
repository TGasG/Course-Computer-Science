<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\RegisterModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    protected UserModel $userModel;
    protected CourseModel $courseModel;
    protected RegisterModel $registerModel;
    protected $user;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        session();
        $this->session = \Config\Services::session();

        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->registerModel = new RegisterModel();
        $this->user = \Config\Services::session()->get('user');

        if ($this->user !== null && $this->user['role'] === 'student') {
            $this->user['registeredCourses'] = $this
                ->registerModel
                ->select(['c.id', 'c.title', 'c.thumbnail'])
                ->join('course c', 'course c on register.courseId = c.id')
                ->join('user u', 'c.author = u.id')
                ->where('register.studentId', $this->user['id'])
                ->orderBy('register.createdAt')
                ->limit(5)
                ->findAll();

            $this->user['registeredCourses'] = array_map(function ($course) {
                if ($course['thumbnail'] === null) $course['thumbnail'] = '/img/thumbnail-placeholder.png';
                return $course;
            }, $this->user['registeredCourses']);
        } else if ($this->user !== null && $this->user['role'] === 'mentor') {
            $this->user['courses'] = $this
                ->courseModel
                ->select(['id', 'title', 'thumbnail'])
                ->where('author', $this->user['id'])
                ->orderBy('createdAt')
                ->limit(5)
                ->findAll();

            $this->user['courses'] = array_map(function ($course) {
                if ($course['thumbnail'] === null) $course['thumbnail'] = '/img/thumbnail-placeholder.png';
                return $course;
            }, $this->user['courses']);
        }

        // E.g.: $this->session = \Config\Services::session();
    }
}
