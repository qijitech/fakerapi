<?php
/**
 *
 * User: YuGang Yang
 * Date: 11/6/15
 * Time: 21:17
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class AuthTransformer extends TransformerAbstract
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id'       => $item->id,
            'phone'    => $item->phone,
            'avatar'   => $item->avatar,
            'nickname' => $item->nickname,
            'token'    => $item->token,
        ];
    }

}