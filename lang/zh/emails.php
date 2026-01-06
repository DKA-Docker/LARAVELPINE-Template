<?php

return [
    'deliveries' => [
        'request_created' => [
            'subject' => '配送申请已创建',
            'title' => '配送申请已创建',
            'greeting' => '您好 :name,',
            'intro' => '您的配送申请已成功创建。以下是您的提交详情。',
            'summary' => [
                'title' => '申请摘要',
                'request_name' => '申请名称',
                'created_at' => '创建时间',
                'urgency' => '紧急程度',
                'status' => '状态',
                'urgent_high' => '高',
                'urgent_normal' => '正常',
                'status_draft' => '草稿',
            ],
            'destinations' => [
                'title' => '目的地 (:count)',
                'no_address' => '未提供地址',
                'no_packages' => '没有列出包裹。',
                'units' => '件',
                'weight_suffix' => 'kg',
            ],
            'footer' => [
                'thank_you' => '感谢您使用 :app。',
                'rights' => '版权所有。',
            ]
        ]
    ]
];
