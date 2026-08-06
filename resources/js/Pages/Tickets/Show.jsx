import React, { useState } from 'react';
import { usePage, router } from '@inertiajs/react';
import {
    Card, Descriptions, Tag, Button, Space, Typography, Select, Divider,
    List, Avatar, Input, Alert, Row, Col, message,
} from 'antd';
import {
    UserOutlined, RobotOutlined, CustomerServiceOutlined, ArrowLeftOutlined,
} from '@ant-design/icons';
import AuthenticatedLayout from '@/Pages/Layouts/AuthenticatedLayout';

const { Title, Text, Paragraph } = Typography;
const { TextArea } = Input;

const statusColors = {
    open: 'blue', ai_replied: 'cyan', escalated: 'orange',
    in_progress: 'processing', resolved: 'green', closed: 'default',
};
const statusLabels = {
    open: 'Terbuka', ai_replied: 'Dibalas AI', escalated: 'Dieskalasi',
    in_progress: 'Dalam Proses', resolved: 'Terselesaikan', closed: 'Ditutup',
};
const priorityColors = { low: 'default', medium: 'blue', high: 'orange', critical: 'red' };
const priorityLabels = { low: 'Rendah', medium: 'Sedang', high: 'Tinggi', critical: 'Kritis' };

export default function TicketsShow({ ticket, statuses }) {
    const [messageText, setMessageText] = useState('');
    const [selectedStatus, setSelectedStatus] = useState(ticket.status);
    const [submitting, setSubmitting] = useState(false);

    const getSenderIcon = (senderType) => {
        switch (senderType) {
            case 'user': return <Avatar size="small" icon={<UserOutlined />} style={{ backgroundColor: '#1677ff' }} />;
            case 'ai': return <Avatar size="small" icon={<RobotOutlined />} style={{ backgroundColor: '#52c41a' }} />;
            case 'admin': return <Avatar size="small" icon={<CustomerServiceOutlined />} style={{ backgroundColor: '#fa8c16' }} />;
            default: return <Avatar size="small" icon={<UserOutlined />} />;
        }
    };

    const getSenderName = (senderType) => {
        switch (senderType) {
            case 'user': return ticket.user?.name || 'Pengguna';
            case 'ai': return 'AI HelpDesk';
            case 'admin': return 'Admin';
            default: return 'Unknown';
        }
    };

    const handleReply = () => {
        if (!messageText.trim()) return;
        setSubmitting(true);
        router.patch(`/tickets/${ticket.id}`, {
            message: messageText,
            status: selectedStatus,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setMessageText('');
                setSubmitting(false);
            },
            onError: () => setSubmitting(false),
        });
    };

    const handleStatusChange = (newStatus) => {
        setSelectedStatus(newStatus);
        router.patch(`/tickets/${ticket.id}`, { status: newStatus }, {
            preserveScroll: true,
            onSuccess: () => message.success('Status berhasil diperbarui'),
        });
    };

    return (
        <AuthenticatedLayout>
            <Space style={{ marginBottom: 16 }}>
                <Button icon={<ArrowLeftOutlined />} href="/tickets">Kembali</Button>
            </Space>

            <Card style={{ marginBottom: 16 }}>
                <Row justify="space-between" align="middle">
                    <Col>
                        <Title level={4} style={{ margin: 0 }}>
                            #{ticket.id} — {ticket.subject}
                        </Title>
                    </Col>
                    <Col>
                        <Space>
                            <Select
                                value={selectedStatus}
                                onChange={handleStatusChange}
                                style={{ width: 180 }}
                                options={statuses.map(s => ({
                                    value: s.value,
                                    label: <Tag color={statusColors[s.value]}>{s.label}</Tag>,
                                }))}
                            />
                        </Space>
                    </Col>
                </Row>
                <Divider style={{ margin: '12px 0' }} />
                <Descriptions column={{ xs: 1, sm: 2, md: 3 }} size="small">
                    <Descriptions.Item label="Aplikasi">{ticket.app?.name}</Descriptions.Item>
                    <Descriptions.Item label="Pelapor">{ticket.user?.name}</Descriptions.Item>
                    <Descriptions.Item label="Prioritas">
                        <Tag color={priorityColors[ticket.priority]}>{priorityLabels[ticket.priority]}</Tag>
                    </Descriptions.Item>
                    <Descriptions.Item label="Sumber">
                        <Tag>{ticket.source === 'web' ? 'Web' : 'Telegram'}</Tag>
                    </Descriptions.Item>
                    <Descriptions.Item label="Dibuat">
                        {new Date(ticket.created_at).toLocaleString('id-ID')}
                    </Descriptions.Item>
                    {ticket.resolved_at && (
                        <Descriptions.Item label="Diselesaikan">
                            {new Date(ticket.resolved_at).toLocaleString('id-ID')}
                        </Descriptions.Item>
                    )}
                </Descriptions>
            </Card>

            {/* Messages Thread */}
            <Card title="Percakapan" style={{ marginBottom: 16 }}>
                <List
                    dataSource={ticket.messages || []}
                    renderItem={(msg) => (
                        <List.Item>
                            <List.Item.Meta
                                avatar={getSenderIcon(msg.sender_type)}
                                title={
                                    <Space>
                                        <Text strong>{getSenderName(msg.sender_type)}</Text>
                                        {msg.is_ai_generated && <Tag color="green" style={{ fontSize: 10 }}>AI</Tag>}
                                        <Text type="secondary" style={{ fontSize: 12 }}>
                                            {new Date(msg.created_at).toLocaleString('id-ID')}
                                        </Text>
                                    </Space>
                                }
                                description={<Paragraph style={{ margin: 0 }}>{msg.message}</Paragraph>}
                            />
                        </List.Item>
                    )}
                    locale={{ emptyText: 'Belum ada pesan.' }}
                />
            </Card>

            {/* Reply Box */}
            <Card title="Balas">
                <Space direction="vertical" style={{ width: '100%' }} size="middle">
                    <TextArea
                        rows={4}
                        placeholder="Ketik balasan..."
                        value={messageText}
                        onChange={e => setMessageText(e.target.value)}
                    />
                    <Button
                        type="primary"
                        onClick={handleReply}
                        loading={submitting}
                    >
                        Kirim Balasan
                    </Button>
                </Space>
            </Card>
        </AuthenticatedLayout>
    );
}
