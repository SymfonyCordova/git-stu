Spring������refresh()������ˢ�¡�;
1��prepareRefresh()ˢ��ǰ��Ԥ����;
	1����initPropertySources()��ʼ��һЩ��������;�����Զ�����Ի����������÷�����
	2����getEnvironment().validateRequiredProperties();�������ԵĺϷ���
	3����earlyApplicationEvents= new LinkedHashSet<ApplicationEvent>();���������е�һЩ���ڵ��¼���
2��obtainFreshBeanFactory();��ȡBeanFactory��
	1����refreshBeanFactory();ˢ�¡�������BeanFactory��
			������һ��this.beanFactory = new DefaultListableBeanFactory();
			����id��
	2����getBeanFactory();���ظղ�GenericApplicationContext������BeanFactory����
	3������������BeanFactory��DefaultListableBeanFactory�����أ�
3��prepareBeanFactory(beanFactory);BeanFactory��Ԥ׼��������BeanFactory����һЩ���ã���
	1��������BeanFactory�����������֧�ֱ���ʽ������...
	2�������Ӳ���BeanPostProcessor��ApplicationContextAwareProcessor��
	3�������ú��Ե��Զ�װ��Ľӿ�EnvironmentAware��EmbeddedValueResolverAware��xxx��
	4����ע����Խ������Զ�װ�䣻������ֱ�����κ�������Զ�ע�룺
			BeanFactory��ResourceLoader��ApplicationEventPublisher��ApplicationContext
	5��������BeanPostProcessor��ApplicationListenerDetector��
	6�������ӱ���ʱ��AspectJ��
	7������BeanFactory��ע��һЩ���õ������
		environment��ConfigurableEnvironment����
		systemProperties��Map<String, Object>����
		systemEnvironment��Map<String, Object>��
4��postProcessBeanFactory(beanFactory);BeanFactory׼��������ɺ���еĺ��ô���������
	1��������ͨ����д�����������BeanFactory������Ԥ׼������Ժ�����һ��������
======================������BeanFactory�Ĵ�����Ԥ׼������==================================
5��invokeBeanFactoryPostProcessors(beanFactory);ִ��BeanFactoryPostProcessor�ķ�����
	BeanFactoryPostProcessor��BeanFactory�ĺ��ô���������BeanFactory��׼��ʼ��֮��ִ�еģ�
	�����ӿڣ�BeanFactoryPostProcessor��BeanDefinitionRegistryPostProcessor
	1����ִ��BeanFactoryPostProcessor�ķ�����
		��ִ��BeanDefinitionRegistryPostProcessor
		1������ȡ���е�BeanDefinitionRegistryPostProcessor��
		2��������ִ��ʵ����PriorityOrdered���ȼ��ӿڵ�BeanDefinitionRegistryPostProcessor��
			postProcessor.postProcessBeanDefinitionRegistry(registry)
		3������ִ��ʵ����Ordered˳��ӿڵ�BeanDefinitionRegistryPostProcessor��
			postProcessor.postProcessBeanDefinitionRegistry(registry)
		4�������ִ��û��ʵ���κ����ȼ�������˳��ӿڵ�BeanDefinitionRegistryPostProcessors��
			postProcessor.postProcessBeanDefinitionRegistry(registry)
			
		
		��ִ��BeanFactoryPostProcessor�ķ���
		1������ȡ���е�BeanFactoryPostProcessor
		2��������ִ��ʵ����PriorityOrdered���ȼ��ӿڵ�BeanFactoryPostProcessor��
			postProcessor.postProcessBeanFactory()
		3������ִ��ʵ����Ordered˳��ӿڵ�BeanFactoryPostProcessor��
			postProcessor.postProcessBeanFactory()
		4�������ִ��û��ʵ���κ����ȼ�������˳��ӿڵ�BeanFactoryPostProcessor��
			postProcessor.postProcessBeanFactory()
6��registerBeanPostProcessors(beanFactory);ע��BeanPostProcessor��Bean�ĺ��ô��������� intercept bean creation��
		��ͬ�ӿ����͵�BeanPostProcessor����Bean����ǰ���ִ��ʱ���ǲ�һ����
		BeanPostProcessor��
		DestructionAwareBeanPostProcessor��
		InstantiationAwareBeanPostProcessor��
		SmartInstantiationAwareBeanPostProcessor��
		MergedBeanDefinitionPostProcessor��internalPostProcessors����
		
		1������ȡ���е� BeanPostProcessor;���ô�������Ĭ�Ͽ���ͨ��PriorityOrdered��Ordered�ӿ���ִ�����ȼ�
		2������ע��PriorityOrdered���ȼ��ӿڵ�BeanPostProcessor��
			��ÿһ��BeanPostProcessor�����ӵ�BeanFactory��
			beanFactory.addBeanPostProcessor(postProcessor);
		3������ע��Ordered�ӿڵ�
		4�������ע��û��ʵ���κ����ȼ��ӿڵ�
		5��������ע��MergedBeanDefinitionPostProcessor��
		6����ע��һ��ApplicationListenerDetector������Bean������ɺ����Ƿ���ApplicationListener�������
			applicationContext.addApplicationListener((ApplicationListener<?>) bean);
7��initMessageSource();��ʼ��MessageSource����������ʻ����ܣ���Ϣ�󶨣���Ϣ��������
		1������ȡBeanFactory
		2�������������Ƿ���idΪmessageSource�ģ�������MessageSource�����
			����и�ֵ��messageSource�����û���Լ�����һ��DelegatingMessageSource��
				MessageSource��ȡ�����ʻ������ļ��е�ĳ��key��ֵ���ܰ���������Ϣ��ȡ��
		3�����Ѵ����õ�MessageSourceע���������У��Ժ��ȡ���ʻ������ļ���ֵ��ʱ�򣬿����Զ�ע��MessageSource��
			beanFactory.registerSingleton(MESSAGE_SOURCE_BEAN_NAME, this.messageSource);	
			MessageSource.getMessage(String code, Object[] args, String defaultMessage, Locale locale);
8��initApplicationEventMulticaster();��ʼ���¼��ɷ�����
		1������ȡBeanFactory
		2������BeanFactory�л�ȡapplicationEventMulticaster��ApplicationEventMulticaster��
		3���������һ��û�����ã�����һ��SimpleApplicationEventMulticaster
		4������������ApplicationEventMulticaster���ӵ�BeanFactory�У��Ժ��������ֱ���Զ�ע��
9��onRefresh();���������������ࣩ
		1��������д���������������ˢ�µ�ʱ������Զ����߼���
10��registerListeners();�������н�������Ŀ�����ApplicationListenerע�������
		1�����������õ����е�ApplicationListener
		2����ÿ�����������ӵ��¼��ɷ����У�
			getApplicationEventMulticaster().addApplicationListenerBean(listenerBeanName);
		3���ɷ�֮ǰ����������¼���
11��finishBeanFactoryInitialization(beanFactory);��ʼ������ʣ�µĵ�ʵ��bean��
	1��beanFactory.preInstantiateSingletons();��ʼ����ʣ�µĵ�ʵ��bean
		1������ȡ�����е�����Bean�����ν��г�ʼ���ʹ�������
		2������ȡBean�Ķ�����Ϣ��RootBeanDefinition
		3����Bean���ǳ���ģ��ǵ�ʵ���ģ��������أ�
			1�����ж��Ƿ���FactoryBean���Ƿ���ʵ��FactoryBean�ӿڵ�Bean��
			2�������ǹ���Bean������getBean(beanName);��������
				0��getBean(beanName)�� ioc.getBean();
				1��doGetBean(name, null, null, false);
				2���Ȼ�ȡ�����б���ĵ�ʵ��Bean������ܻ�ȡ��˵�����Bean֮ǰ�������������д������ĵ�ʵ��Bean���ᱻ����������
					��private final Map<String, Object> singletonObjects = new ConcurrentHashMap<String, Object>(256);��ȡ��
				3�������л�ȡ��������ʼBean�Ĵ����������̣�
				4����ǵ�ǰbean�Ѿ�������
				5����ȡBean�Ķ�����Ϣ��
				6������ȡ��ǰBean����������Bean;����а���getBean()��������Bean�ȴ�����������
				7��������ʵ��Bean�Ĵ������̣�
					1����createBean(beanName, mbd, args);
					2����Object bean = resolveBeforeInstantiation(beanName, mbdToUse);��BeanPostProcessor�����ط��ش�������
						��InstantiationAwareBeanPostProcessor������ǰִ�У�
						�ȴ�����postProcessBeforeInstantiation()��
						����з���ֵ������postProcessAfterInitialization()��
					3�������ǰ���InstantiationAwareBeanPostProcessorû�з��ش������󣻵���4��
					4����Object beanInstance = doCreateBean(beanName, mbdToUse, args);����Bean
						 1����������Beanʵ������createBeanInstance(beanName, mbd, args);
						 	���ù����������߶���Ĺ�����������Beanʵ����
						 2����applyMergedBeanDefinitionPostProcessors(mbd, beanType, beanName);
						 	����MergedBeanDefinitionPostProcessor��postProcessMergedBeanDefinition(mbd, beanType, beanName);
						 3������Bean���Ը�ֵ��populateBean(beanName, mbd, instanceWrapper);
						 	��ֵ֮ǰ��
						 	1�����õ�InstantiationAwareBeanPostProcessor���ô�������
						 		postProcessAfterInstantiation()��
						 	2�����õ�InstantiationAwareBeanPostProcessor���ô�������
						 		postProcessPropertyValues()��
						 	=====��ֵ֮ǰ��===
						 	3����Ӧ��Bean���Ե�ֵ��Ϊ��������setter�����Ƚ��и�ֵ��
						 		applyPropertyValues(beanName, mbd, bw, pvs);
						 4������Bean��ʼ����initializeBean(beanName, exposedObject, mbd);
						 	1������ִ��Aware�ӿڷ�����invokeAwareMethods(beanName, bean);ִ��xxxAware�ӿڵķ���
						 		BeanNameAware\BeanClassLoaderAware\BeanFactoryAware
						 	2������ִ�к��ô�������ʼ��֮ǰ��applyBeanPostProcessorsBeforeInitialization(wrappedBean, beanName);
						 		BeanPostProcessor.postProcessBeforeInitialization����;
						 	3������ִ�г�ʼ��������invokeInitMethods(beanName, wrappedBean, mbd);
						 		1�����Ƿ���InitializingBean�ӿڵ�ʵ�֣�ִ�нӿڹ涨�ĳ�ʼ����
						 		2�����Ƿ��Զ����ʼ��������
						 	4������ִ�к��ô�������ʼ��֮��applyBeanPostProcessorsAfterInitialization
						 		BeanPostProcessor.postProcessAfterInitialization()��
						 5����ע��Bean�����ٷ�����
					5������������Bean���ӵ�������singletonObjects��
				ioc����������ЩMap���ܶ��Map���汣���˵�ʵ��Bean��������Ϣ����������
		����Bean������getBean��������Ժ�
			������е�Bean�Ƿ���SmartInitializingSingleton�ӿڵģ�����ǣ���ִ��afterSingletonsInstantiated()��
12��finishRefresh();���BeanFactory�ĳ�ʼ������������IOC�����ʹ�����ɣ�
		1����initLifecycleProcessor();��ʼ�������������йصĺ��ô�������LifecycleProcessor
			Ĭ�ϴ����������Ƿ���lifecycleProcessor�������LifecycleProcessor�������û��new DefaultLifecycleProcessor();
			���뵽������
			
			дһ��LifecycleProcessor��ʵ���࣬������BeanFactory
				void onRefresh();
				void onClose();	
		2����	getLifecycleProcessor().onRefresh();
			�õ�ǰ�涨����������ڴ�������BeanFactory�����ص�onRefresh()��
		3����publishEvent(new ContextRefreshedEvent(this));��������ˢ������¼���
		4����liveBeansView.registerApplicationContext(this);
	
	======�ܽ�===========
	1����Spring������������ʱ���Ȼᱣ������ע�������Bean�Ķ�����Ϣ��
		1����xmlע��bean��<bean>
		2����ע��ע��Bean��@Service��@Component��@Bean��xxx
	2����Spring��������ʵ�ʱ��������ЩBean
		1�����õ����bean��ʱ������getBean����bean���������Ժ󱣴��������У�
		2����ͳһ����ʣ�����е�bean��ʱ��finishBeanFactoryInitialization()��
	3�������ô�������BeanPostProcessor
		1����ÿһ��bean������ɣ�����ʹ�ø��ֺ��ô��������д���������ǿbean�Ĺ��ܣ�
			AutowiredAnnotationBeanPostProcessor:�����Զ�ע��
			AnnotationAwareAspectJAutoProxyCreator:����AOP���ܣ�
			xxx....
			��ǿ�Ĺ���ע�⣺
			AsyncAnnotationBeanPostProcessor
			....
	4�����¼�����ģ�ͣ�
		ApplicationListener���¼�������
		ApplicationEventMulticaster���¼��ɷ���
	
			
					
						 		
						 	
					
								
							
							
							
						
						
						
							
						
						
					
				
				
				
			

		
	
	