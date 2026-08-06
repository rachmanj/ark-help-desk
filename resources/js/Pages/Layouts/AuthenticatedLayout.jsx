import React from 'react';
import { usePage } from '@inertiajs/react';
import { Layout, Menu, Button, Typography, theme, Space, Avatar, Dropdown } from 'antd';
import {
    DashboardOutlined,
    UnorderedListOutlined,
    BookOutlined,
    LogoutOutlined,
    UserOutlined,
} from '@ant-design/icons';

const { Header, Sider, Content } = Layout;
const { Text } = Typography;

export default function AuthenticatedLayout({ children }) {
    const { auth } = usePage().props;
    const { token: { colorBgContainer, borderRadiusLG } } = theme.useToken();

    const currentPath = window.location.pathname;

    const menuItems = [
        {
            key: '/dashboard',
            icon: <DashboardOutlined />,
            label: 'Dasbor',
        },
        {
            key: '/tickets',
            icon: <UnorderedListOutlined />,
            label: 'Tiket',
        },
        {
            key: '/kb',
            icon: <BookOutlined />,
            label: 'Basis Pengetahuan',
        },
    ];

    const userMenuItems = [
        {
            key: 'logout',
            icon: <LogoutOutlined />,
            label: 'Keluar',
            danger: true,
        },
    ];

    const handleMenuClick = ({ key }) => {
        if (key === 'logout') {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/logout';
            document.body.appendChild(form);
            form.submit();
        } else {
            window.location.href = key;
        }
    };

    return (
        <Layout style={{ minHeight: '100vh' }}>
            <Sider
                breakpoint="lg"
                collapsedWidth="0"
                style={{ background: colorBgContainer }}
            >
                <div style={{
                    height: 64,
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    borderBottom: '1px solid #f0f0f0',
                }}>
                    <Text strong style={{ fontSize: 18, color: '#1677ff' }}>
                        ARKA HelpDesk
                    </Text>
                </div>
                <Menu
                    mode="inline"
                    selectedKeys={[currentPath]}
                    items={menuItems}
                    onClick={handleMenuClick}
                    style={{ borderRight: 0 }}
                />
            </Sider>
            <Layout>
                <Header style={{
                    padding: '0 24px',
                    background: colorBgContainer,
                    display: 'flex',
                    justifyContent: 'flex-end',
                    alignItems: 'center',
                    borderBottom: '1px solid #f0f0f0',
                }}>
                    <Dropdown
                        menu={{ items: userMenuItems, onClick: handleMenuClick }}
                        placement="bottomRight"
                    >
                        <Space style={{ cursor: 'pointer' }}>
                            <Avatar size="small" icon={<UserOutlined />} />
                            <Text>{auth?.user?.name || 'Pengguna'}</Text>
                        </Space>
                    </Dropdown>
                </Header>
                <Content style={{ margin: 24 }}>
                    <div style={{
                        padding: 24,
                        minHeight: 360,
                        background: colorBgContainer,
                        borderRadius: borderRadiusLG,
                    }}>
                        {children}
                    </div>
                </Content>
            </Layout>
        </Layout>
    );
}
