import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Form, Input, Button, Card, Typography, Alert, Space } from 'antd';
import { MailOutlined, LockOutlined } from '@ant-design/icons';

const { Title, Text } = Typography;

export default function Login({ flash }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [form] = Form.useForm();

    const handleSubmit = () => {
        post('/login');
    };

    return (
        <div style={{
            minHeight: '100vh',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        }}>
            <Card style={{ width: 400, borderRadius: 12 }}>
                <Space direction="vertical" size="large" style={{ width: '100%' }}>
                    <div style={{ textAlign: 'center' }}>
                        <Title level={2} style={{ margin: 0 }}>ARKA HelpDesk</Title>
                        <Text type="secondary">Masuk ke dashboard</Text>
                    </div>

                    {flash?.error && (
                        <Alert message={flash.error} type="error" showIcon />
                    )}

                    <Form
                        form={form}
                        layout="vertical"
                        onFinish={handleSubmit}
                        autoComplete="off"
                    >
                        <Form.Item
                            label="Email"
                            validateStatus={errors.email ? 'error' : ''}
                            help={errors.email}
                        >
                            <Input
                                prefix={<MailOutlined />}
                                placeholder="admin@helpdesk.test"
                                value={data.email}
                                onChange={e => setData('email', e.target.value)}
                            />
                        </Form.Item>

                        <Form.Item
                            label="Kata Sandi"
                            validateStatus={errors.password ? 'error' : ''}
                            help={errors.password}
                        >
                            <Input.Password
                                prefix={<LockOutlined />}
                                placeholder="Masukkan kata sandi"
                                value={data.password}
                                onChange={e => setData('password', e.target.value)}
                            />
                        </Form.Item>

                        <Form.Item>
                            <Button
                                type="primary"
                                htmlType="submit"
                                loading={processing}
                                block
                                size="large"
                            >
                                Masuk
                            </Button>
                        </Form.Item>
                    </Form>
                </Space>
            </Card>
        </div>
    );
}
