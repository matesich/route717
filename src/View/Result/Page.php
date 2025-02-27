<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\UrlrewriteGraphql
 * @author    Vladimirs Mihnovics <info@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */

namespace ScandiPWA\Router\View\Result;

use Magento\Framework;
use Magento\Framework\View;
use Magento\Framework\View\Result\Page as ExtendedPage;

class Page extends ExtendedPage
{
    /**
     * @var string
     */
    protected $pageLayout;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $pageConfig;

    /**
     * @var \Magento\Framework\View\Page\Config\RendererInterface
     */
    protected $pageConfigRenderer;

    /**
     * @var \Magento\Framework\View\Page\Config\RendererFactory
     */
    protected $pageConfigRendererFactory;

    /**
     * @var \Magento\Framework\View\Page\Layout\Reader
     */
    protected $pageLayoutReader;

    /**
     * @var \Magento\Framework\View\FileSystem
     */
    protected $viewFileSystem;

    /**
     * @var array
     */
    protected $viewVars;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var Framework\App\RequestInterface
     */
    protected $request;

    /**
     * Asset service
     *
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var View\EntitySpecificHandlesList
     */
    private $entitySpecificHandlesList;

    /**
     * @var string;
     */
    private $action;

    /**
     * @var array;
     */
    private $rootTemplatePool;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $display_mode;

    /**
     * @var array|null
     */
    protected $cmsPage;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $catalogDefaultSortBy;

    /**
     * @var array|null
     */
    protected $storeConfig;

    /**
     * Constructor
     *
     * @param View\Element\Template\Context $context
     * @param View\LayoutFactory $layoutFactory
     * @param View\Layout\ReaderPool $layoutReaderPool
     * @param Framework\Translate\InlineInterface $translateInline
     * @param View\Layout\BuilderFactory $layoutBuilderFactory
     * @param View\Layout\GeneratorPool $generatorPool
     * @param View\Page\Config\RendererFactory $pageConfigRendererFactory
     * @param View\Page\Layout\Reader $pageLayoutReader
     * @param string $template
     * @param bool $isIsolated
     * @param View\EntitySpecificHandlesList $entitySpecificHandlesList
     * @param string $action
     * @param array $rootTemplatePool
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        View\Element\Template\Context $context,
        View\LayoutFactory $layoutFactory,
        View\Layout\ReaderPool $layoutReaderPool,
        Framework\Translate\InlineInterface $translateInline,
        View\Layout\BuilderFactory $layoutBuilderFactory,
        View\Layout\GeneratorPool $generatorPool,
        View\Page\Config\RendererFactory $pageConfigRendererFactory,
        View\Page\Layout\Reader $pageLayoutReader,
        $template,
        $isIsolated = false,
        View\EntitySpecificHandlesList $entitySpecificHandlesList = null,
        $action = null,
        $rootTemplatePool = []
    ) {
        parent::__construct(
            $context,
            $layoutFactory,
            $layoutReaderPool,
            $translateInline,
            $layoutBuilderFactory,
            $generatorPool,
            $pageConfigRendererFactory,
            $pageLayoutReader,
            $template,
            $isIsolated,
            $entitySpecificHandlesList
        );
        $this->action = $action;
        $this->rootTemplatePool = $rootTemplatePool;
        $this->id = '';
        $this->sku = '';
        $this->name = '';
        $this->display_mode = '';
        $this->cmsPage = null;
        $this->slider = null;
        $this->description = '';
        $this->catalogDefaultSortBy = '';
        $this->storeConfig = null;
    }

    /**
     * Set action type
     *
     * @param string
     * @return \Magento\Framework\View\Result\Page
     */
    public function setAction(string $actionType)
    {
        if($this->action === null) {
            $this->action = $actionType;
            return $this;
        }

        return null;
    }

    /**
     * Retrieve action type
     *
     * @return  string
     */
    public function getAction()
    {
        return $this->action;
    }

    public function setId(string $id)
    {
        if($this->id === '') {
            $this->id = $id;
            return $this;
        }

        return '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSku(string $sku)
    {
        if($this->sku === '') {
            $this->sku = $sku;
            return $this;
        }

        return '';
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setName(string $name)
    {
        if($this->name === '') {
            $this->name = $name;
            return $this;
        }

        return '';
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDisplayMode(string $display_mode)
    {
        if($this->display_mode === '') {
            $this->display_mode = $display_mode;
            return $this;
        }

        return '';
    }

    public function getDisplayMode()
    {
        return $this->display_mode;
    }

    public function setCmsPage($cmsPage)
    {
        if($this->cmsPage === null) {
            $this->cmsPage = $cmsPage;
            return $this;
        }

        return null;
    }

    public function getCmsPage()
    {
        return $this->cmsPage;
    }

    public function setDescription(string $description)
    {
        if($this->description === '') {
            $this->description = $description;
            return $this;
        }

        return '';
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCatalogDefaultSortBy(string $catalogDefaultSortBy)
    {
        if($this->catalogDefaultSortBy === '') {
            $this->catalogDefaultSortBy = $catalogDefaultSortBy;
            return $this;
        }

        return '';
    }

    public function getCatalogDefaultSortBy()
    {
        return $this->catalogDefaultSortBy;
    }

    public function setStoreConfig($storeConfig)
    {
        if ($this->storeConfig === null) {
            $this->storeConfig = $storeConfig;
            return $this;
        }

        return null;
    }

    public function getStoreConfig()
    {
        return $this->storeConfig;
    }

    public function setSlider($slider)
    {
        if ($this->slider === null) {
            $this->slider = $slider;
            return $this;
        }

        return '';
    }

    public function getSlider()
    {
        return $this->slider;
    }

    public function getCatalogDefaultSortByConfig()
    {
        return $this->storeConfig;
    }

    /**
     * @param string $template
     * @return Page
     * @throws Framework\Exception\LocalizedException
     */
    public function setRootTemplate($template)
    {
        if (in_array($template, array_keys($this->rootTemplatePool))) {
            $this->template = $this->rootTemplatePool[$template];
        } else {
            throw new Framework\Exception\LocalizedException(__('Invalid root template specified'));
        }
        return $this;
    }
}
