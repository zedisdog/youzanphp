<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;

class OrderTags extends BaseModel
{
    /**
     * @var bool 是否虚拟订单
     */
    public $isVirtual;
    /**
     * @var bool 是否采购单
     */
    public $isPurchaseOrder;
    /**
     * @var bool 是否分销单
     */
    public $isFenxiaoOrder;
    /**
     * @var bool 是否会员订单
     */
    public $isMember;
    /**
     * @var bool 是否预订单
     */
    public $isPreorder;
    /**
     * @var bool 是否线下订单
     */
    public $isOfflineOrder;
    /**
     * @var bool 是否多门店订单
     */
    public $isMultiStore;
    /**
     * @var bool 是否结算
     */
    public $isSettle;
    /**
     * @var bool 是否支付
     */
    public $isPayed;
    /**
     * @var bool 是否担保交易
     */
    public $isSecuredTransactions;
    /**
     * @var bool 是否享受免邮
     */
    public $isPostageFree;
    /**
     * @var bool 是否有维权
     */
    public $isFeedback;
    /**
     * @var bool 是否有退款
     */
    public $isRefund;
    /**
     * @var bool 是否定金预售
     */
    public $isDownPaymentPre;
}